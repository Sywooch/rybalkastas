<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Query;
use yii\helpers\BaseInflector;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\validators\EmailValidator;
use common\components\ArrayToXmlA;
use common\components\UtUploader;
use common\models\mongo\ProductAttributes;
use common\models\mongo\ProductInfo;
use common\models\SCCategories;
use common\models\SCCustomers;
use common\models\SCMonufacturers;
use common\models\SCOrders;
use common\models\SCProductPictures;
use common\models\SCProducts;
use common\models\SCRelatedCategories;
use common\models\SCSecondaryPagesLinks;
use common\models\SCTags;
use common\models\stack\StackTaskPacks;
use common\models\stack\StackTasks;
use common\models\SubscribedMails;
use common\models\User;
use common\models\ut\Nomenclature;
use frontend\components\ImageMan;

class ReignierController extends  Controller
{
    public function actionTestCategories()
    {
        $ts = time();

        $folder = Yii::getAlias('@frontend/ragnar');
        $frontend = Yii::getAlias('@frontend');

        $file = fopen($folder."/errors_$ts.html", 'w');

        $allCategories = SCCategories::find()->select('categoryID')->asArray()->all();
        $count = count($allCategories);
        $ch = curl_init();

        $url = 'http://rybalka.tech';
        $options = array(
            CURLOPT_URL             => $url,
            CURLOPT_REFERER         => $url,
            CURLOPT_FOLLOWLOCATION  => 1,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_COOKIESESSION   => true,
            CURLOPT_COOKIEJAR       => 'curl-cookie.txt',
            CURLOPT_COOKIEFILE      => $frontend.'/web/tmp',
            CURLOPT_CONNECTTIMEOUT  => 0,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_USERAGENT       => "Dark Secret Ninja/1.0",
            CURLOPT_POST            => 1,
            CURLOPT_POSTFIELDS      => "login-form[login]=".'Sunderland'.
                "&login-form[password]=".'md123456md'.
                "&login-form[rememberMe]=1",
            CURLOPT_SSL_VERIFYPEER  => false,
        );
        curl_setopt_array( $ch, $options );

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        echo 'LOGGED IN!'.PHP_EOL;

        foreach ($allCategories as $c){
            if($c['categoryID'] == 1)continue;
            $url = 'http://rybalka.tech/shop/category?id='.$c['categoryID'];
            //$url = Url::to(['shop/category', 'id'=>$c['categoryID']], true);


            $options = array(
                CURLOPT_URL             => $url,
                CURLOPT_REFERER         => $url,
                CURLOPT_FOLLOWLOCATION  => 1,
                CURLOPT_RETURNTRANSFER  => 1,
                CURLOPT_COOKIESESSION   => true,
                CURLOPT_COOKIEJAR       => 'curl-cookie.txt',
                CURLOPT_COOKIEFILE      => $frontend.'/web/tmp',
                CURLOPT_CONNECTTIMEOUT  => 0,
                CURLOPT_TIMEOUT         => 0,
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_USERAGENT       => "Dark Secret Ninja/1.0",
            );
            curl_setopt_array( $ch, $options );

            $response = curl_exec($ch);
            $httpCode = curl_getinfo(
                $ch,
                    CURLINFO_HTTP_CODE);
               //get status code
            $count--;
            if ( $httpCode != 200 ){
                echo $c['categoryID'].'... ERROR '.$httpCode.PHP_EOL;
                $error_msg = curl_error($ch);
                $h3 = "categoryID = ".$c['categoryID'];

                $html = <<< HTML
                        <div>
                            <h3>$h3</h3>
                            <div class="errorcode">
                            <code>$error_msg</code>
                            </div>
                        </div>
                        <hr>
                        <hr>
                        <hr>

HTML;
                fwrite($file, $html);
            } else {
                echo $c['categoryID'].'... OK 200! '.$count.' left'.PHP_EOL;
                //echo htmlspecialchars($response);
            }


            //curl_close($ch);
        }
        fclose($file);
    }

    public function actionTryCats()
    {
        $model = SCCategories::find()->where('meta_data IS NULL')->asArray()->all();
        $count = count($model);
        $i = 0;
        foreach ($model as $m){
            $find = SCCategories::findOne($m['categoryID']);
            $find->generateMeta();
            $i++;
            echo "$i / $count".PHP_EOL;
        }
    }

    public function actionLoadProducts(){
        $model = SCProducts::find()->where('is_hidden = 0')->all();
        $count = count($model);
        $i = 0;
        foreach ($model as $m){
            $i++;
            echo $i.'/'.$count.PHP_EOL;
            if($i<2038)continue;
            Nomenclature::findByCode($m->product_code);
        }
    }

    public function actionRegenMeta()
    {
        $model = SCCategories::find()->select(['categoryID'])->where('hidden <> 1')->all();
        $count = count($model);
        echo $count.PHP_EOL;
        $i = 1;
        foreach ($model as $m){
            if($m->categoryID == 1)continue;
            /*$find = SCCategories::findOne($m['categoryID']);
            if(empty($find))continue;*/
            echo "$i / $count ($m->categoryID)".PHP_EOL;
            $m->generateMeta();

            echo 'Регенерация мета-данных категории ' . $m->name_ru . ' прошла успешно!' . PHP_EOL;

            $i++;
        }
    }

    public function actionRegenPartial()
    {
        $c = SCCategories::findOne(125721);
        $c->generateMeta();
    }

    public function actionRename()
    {
        $customers = SCCustomers::find()->select(['customerID', 'Login', 'Email'])->asArray()->all();
        $wrongNamesAr = [];
        foreach ($customers as $cus){

            if(preg_match('/[ ]/iu', $cus['Login'])){
                //echo BaseInflector::transliterate($cus['Login']).PHP_EOL;
                $wrongNamesAr[] = ['id'=>$cus['customerID'], 'name'=>BaseInflector::transliterate($cus['Login']), 'email'=>$cus['Email'], 'oldname'=>$cus['Login']];
            }
        }

        $mailer = \Yii::$app->getMailer();

        $count = count($wrongNamesAr);

        $i = 0;
        foreach ($wrongNamesAr as $ar){
            $i++;
            $name = $ar['name'];
            $name = str_replace(' ', '', $name);
            $name = str_replace(',', '', $name);
            $name = str_replace('/', '', $name);
            $name = str_replace('\\', '', $name);
            $name = str_replace('=', '', $name);
            $name = str_replace('*', '', $name);

            $search = SCCustomers::find()->where(['Login'=>$name])->one();
            if(!empty($search)){
                $name = $name.'_1';
            }

            $search = SCCustomers::find()->where(['Login'=>$name])->one();
            if(!empty($search)){
                $name = $name.'_1';
            }

            $user = SCCustomers::findOne($ar['id']);
            $user->Login = $name;
            $user->cust_password = BaseInflector::transliterate($user->cust_password);
            $user->rebuilt = 1;
            if($user->save()){
                /*try{
                    $mail = $mailer->compose(['html'=>'@frontend/views/mail/rebuild'],['login'=>$user->Login, 'password'=>base64_decode($user->cust_password)])
                        ->setFrom(['support@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
                    $mail->setTo($user->Email);
                    $mail->setSubject("Тестовое");
                    $mail->send();
                } catch (\Exception $e){
                    \Yii::$app->bot->sendMessage(-14068578, $e->getMessage());
                }*/
                //echo $user->Email.PHP_EOL;
            }
            echo "$i/$count --- ".$ar['oldname'].' => '.$user->Login.PHP_EOL;
            //echo $name.PHP_EOL;
        }

    }

    public function actionGetRebuilt()
    {
        $custs = SCCustomers::find()->where(['rebuilt'=>1])->andWhere('user_id IS NULL')->all();
        foreach ($custs as $c){
            echo $c->Email.PHP_EOL;
        }
    }

    public function actionCheckmail()
    {
        $customer = SCCustomers::find()->where(['Email'=>'denvolin@gmail.com'])->andWhere(['login'=>'Sunderland'])->one();
        $mailer = \Yii::$app->mailer_s;

        //$mailer->
        $mail = $mailer->compose(['html'=>'@frontend/views/mail/rebuild'],['login'=>$customer->Login, 'password'=>base64_decode($customer->cust_password)])
            ->setFrom(['contacts@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
        $mail->setTo($customer->Email);
        $mail->setSubject("Тестовое");
        $mail->send();
    }

    public function actionEmpty()
    {
        $customers = SCCustomers::find()->where(['first_name'=>''])->orWhere(['last_name'=>''])->andWhere("Login <> ''")->all();

        $count = count($customers);
        $i = 0;
        $done = 0;
        $mailer = \Yii::$app->getMailer();
        foreach ($customers as $customer){
            $i++;
            $orders = SCOrders::find()->where(['customerID'=>$customer->customerID]);


            foreach ($orders as $o){
                if(!empty($o->customer_first_name)){
                    $customer->first_name = $o->customer_first_name;
                    continue;
                }
            }

            foreach ($orders as $o){
                if(!empty($o->customer_last_name)){
                    $customer->last_name = $o->customer_last_name;
                    continue;
                }
            }

            if(empty($customer->first_name)){
                $customer->first_name = "1";
            }

            if(empty($customer->last_name)){
                $customer->last_name = "1";
            }

            if(!empty($customer->first_name) && !empty($customer->last_name)){
                if($customer->save()){
                    try{
                        $done++;

                        $mail = $mailer->compose(['html'=>'@frontend/views/mail/refill'],['login'=>$customer->Login, 'password'=>base64_decode($customer->cust_password)])
                            ->setFrom(['support@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
                        $mail->setTo($customer->Email);
                        $mail->setSubject("Тестовое");

                        $mail->send();
                    } catch (\Exception $e){
                        \Yii::$app->bot->sendMessage(-14068578, $e->getMessage());
                    }

                    echo "$done/$count ".$customer->Email.PHP_EOL;
                }
            } else {
                echo "$i/$count SKIP".PHP_EOL;
            }

        }
    }

    public function actionGoGenya()
    {
        $id = SCCustomers::findOne(41107)->user_id;
        $user = User::findOne($id);
        //F00049053
        $uploader = new UtUploader();
        $uploader->MoveCard($user);
    }

    public function actionMerge()
    {
       /* $id = SCCustomers::find()->where(['1c_id'=>'F00012187'])->one()->user_id;
        $user = User::findOne($id);
        //F00049053
        $uploader = new UtUploader();
        $ma = $uploader->MergeAccounts($user);
        $user->customer->reset_id_1c = $user->customer->{'1c_id'};
        $user->customer->save();
        echo Json::encode($ma).PHP_EOL;*/


        $users = User::find()->all();
        foreach ($users as $u){
            if(!empty($u->customer->reset_id_1c))continue;
            if(empty($u->customer->{'1c_id'})) continue;

            $uploader = new UtUploader();
            try {
                $ma = $uploader->MergeAccounts($u);
                $u->customer->reset_id_1c = $u->customer->{'1c_id'};
                $u->customer->save();
                echo Json::encode($ma).PHP_EOL;
            } catch (\Exception $e){
                echo "MISS".PHP_EOL;
            }
        }
    }

    public function actionLoadCities()
    {
        /*$ar = [];

        $ar[] = ['login' => 'alexandr_belov', 'password'=>'438483589924', 'name'=>'Александр Белов', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'alexandr_gerasimov', 'password'=>'419992314380', 'name'=>'Александр Герасимов', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'alexandr_poddaev', 'password'=>'717946982412', 'name'=>'Александр Поддаев', 'shop'=>'Ярцевская'];
        $ar[] = ['login' => 'alexandr_popov', 'password'=>'379326220434', 'name'=>'Александр Попов', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'andrey_donskov', 'password'=>'373390816677', 'name'=>'Андрей Донсков', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'andrey_grechishnikov', 'password'=>'279537793144', 'name'=>'Андрей Гречишников', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'andrey_grinevich', 'password'=>'126626056710', 'name'=>'Андрей Гриневич', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'andrey_molchanov', 'password'=>'372422751368', 'name'=>'Андрей Молчанов', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'andrey_shirukov', 'password'=>'337819148168', 'name'=>'Андрей Ширюков', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'denis_chizhov', 'password'=>'251149009276', 'name'=>'Денис Чижов', 'shop'=>'Братиславская'];
        $ar[] = ['login' => 'denis_lizhenkov', 'password'=>'887630421266', 'name'=>'Денис Лыженков', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'didenko_igor', 'password'=>'795644115737', 'name'=>'Игорь Диденко', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'dmitriy_egorov', 'password'=>'817253184668', 'name'=>'Евгений Егоров', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'dmitriy_smirnov', 'password'=>'668367773495', 'name'=>'Дмитрий Смирнов', 'shop'=>'Ярцевская'];
        $ar[] = ['login' => 'evgeniy_viktorov', 'password'=>'703557288057', 'name'=>'Евгений Викторов', 'shop'=>'Братиславская'];
        $ar[] = ['login' => 'frolov_sergey', 'password'=>'424951815349', 'name'=>'Сергей Фролов', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'gribov_dmitriy', 'password'=>'346315381103', 'name'=>'Дмитрий Грибов', 'shop'=>'Ярцевская'];
        $ar[] = ['login' => 'igor_borisov', 'password'=>'189882787986', 'name'=>'Игорь Борисов', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'ilya_purishev', 'password'=>'828936279889', 'name'=>'Илья Пурышев', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'kirill_saharov', 'password'=>'608092924609', 'name'=>'Кирилл Сахаров', 'shop'=>'Ярцевская'];
        $ar[] = ['login' => 'kuharenko_roman', 'password'=>'233946127819', 'name'=>'Роман Кухаренко', 'shop'=>'Братиславская'];
        $ar[] = ['login' => 'matvey_mishin', 'password'=>'752084220882', 'name'=>'Матвей Мишин', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'roman_rozhkov', 'password'=>'645455340991', 'name'=>'Роман Рожков', 'shop'=>'Пав.№2'];
        $ar[] = ['login' => 'sergey_demchenkov', 'password'=>'379140185032', 'name'=>'Сергей Демченков', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'sergey_kirutkin', 'password'=>'464565429603', 'name'=>'Сергей Киюткин', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'sergey_yantarov', 'password'=>'252134408660', 'name'=>'Сергей Янтаров', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'sergey_zhdanov', 'password'=>'827682116586', 'name'=>'Сергей Жданов', 'shop'=>'Шоу-Рум'];
        $ar[] = ['login' => 'timofey_zikin', 'password'=>'218257637907', 'name'=>'Тимофей Зыкин', 'shop'=>'Братиславская'];
        $ar[] = ['login' => 'vasiliy_krilov', 'password'=>'547670359970', 'name'=>'Василий Крылов', 'shop'=>'Пав.№1'];
        $ar[] = ['login' => 'vitaliy_kozlov', 'password'=>'457034732661', 'name'=>'Виталий Козлов', 'shop'=>'Братиславская'];
        $mailer = \Yii::$app->getMailer();

        foreach ($ar as $a){
            $user = User::find()->where(['username'=>$a['login']])->one();

            $mail = $mailer->compose(['html'=>'@frontend/views/mail/mngpassword'],['login'=>$a['login'], 'password'=>$a['password'], 'name'=>$a['name'], 'shop'=>$a['shop']])
                ->setFrom(['support@rybalkashop.ru' => 'Rybalkashop.ru БОТ']);
            $mail->setTo($user->email);
            $mail->setSubject("Данные учетной записи для сайта");

            $mail->send();
        }*/
    }

    public function actionMakeHashes()
    {
        $m = User::find()->groupBy('email')->all();
        $em = new EmailValidator();
        foreach ($m as $mi){
            if(!$em->validate($mi->email))continue;
            $check = SubscribedMails::find()->where(['email'=>$mi->email])->one();
            if(!empty($check))continue;

            $sm = new SubscribedMails();
            $sm->email = $mi->email;
            $sm->save();
        }
    }

    public function actionSyncProducts()
    {
        $model = SCProducts::find()->select(['product_code', 'productID'])->where("in_stock > 0")->andWhere('updated_at < "2017-06-01"')->orderBy('RAND()')->asArray()->all();
        $count = count($model);
        $i = 0;
        foreach ($model as $m){
            $i++;
            Nomenclature::findByCode($m['product_code']);
            echo $i.'/'.$count. '  ('.$m['productID'].')'.PHP_EOL;
        }
    }

    public function actionBuildXml()
    {
        $data = [
            'shop' => [
                'name' => 'Рыболов на Птичке',
                'company' => 'ИП Русяев Максим Васильевич',
                'url' => 'http://rybalkashop.ru',
                'currencies' => [
                    'currency' => [
                        '@id' => 'RUR',
                        '@rate' => '1'
                    ]
                ],
                'categories'=>[],
                'offers'=>[],
            ]
        ];

        $cats = SCCategories::find()->all();
        foreach ($cats as $c){
            $data['shop']['categories']['category'][] = [

                    '@id' => $c->categoryID,
                    '@parentId' => $c->parent,
                    '%' => $c->name_ru

            ];
        }

        $products = SCProducts::find()->where(['upload2market'=>1])->all();
        foreach ($products as $p){
            $data['shop']['offers']['offer'][] = [

                    '@id'=>$p->productID,
                    '@available'=>$p->in_stock > 0?'true':'false',
                    'price'=>$p->Price,
                    'old_price'=>$p->list_price,
                    'currencyId'=>'RUR',
                    'categoryId'=>$p->categoryID,
                    'category'=>$p->category->categoryID,
                    'picture'=>!empty($p->picurl)?$p->picurl:null,
                    'store'=>$p->in_stock > $p->in_stock_provider?'true':'false',
                    'vendor'=>!empty($p->category->monufacturer)?ucfirst($p->category->monufacturer):null,
                    'name'=>$p->name_ru,
                    'description'=>$p->category->description_ru,
                    'sales_notes'=>'Минимальная сумма заказа: 1000 руб.'

            ];
        }

        $xml = new ArrayToXmlA();
        $file = Yii::getAlias('@frontend/web/market.xml');
        file_put_contents($file, $xml->buildXML($data));
        //print $xml->buildXML($data);
    }

    public function actionBuildCorrectXml()
    {
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $date = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i');
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><yml_catalog></yml_catalog>");
        $xml->addAttribute('date', $date);

        $shop = $xml->addChild('shop');
        $shop->addChild('name', 'Рыболов на Птичке');
        $shop->addChild('company', 'ИП Русяев Максим Васильевич');
        $shop->addChild('url', 'http://rybalkashop.ru');

        $currencies = $shop->addChild('currencies');
        $rur = $currencies->addChild('currency');
        $rur->addAttribute('id', 'RUR');
        $rur->addAttribute('rate', '1');
        $categories = $shop->addChild('categories');
        $offers = $shop->addChild('offers');


        $cats = SCCategories::find()->all();

        foreach ($cats as $c){
            $category = $categories->addChild('category', htmlspecialchars($c->name_ru));
            $category->addAttribute('id', $c->categoryID);
            $category->addAttribute('parentId', $c->parent);
        }

        $products = SCProducts::find()->where(['upload2market'=>1])->all();
        $count = 0;

        $skipWOPrice = 0;
        $skipStock = 0;
        $skipPics = 0;
        $skipStops = 0;


        foreach ($products as $p){
            if ($p->Price <= 0) {
                $skipWOPrice++;
                continue;
            }

            if ($p->in_stock <= 0) {
                $skipStock++;
                continue;
            }

            if (empty($p->pictures[0])) {
                $skipPics++;
                continue;
            }

            $keywords = array (
                'скидка',
                'распродажа',
                'дешевый',
                'подарок',
                'бесплатно',
                'акция',
                'специальная цена',
                'новинка',
                'new',
                'аналог',
                'заказ',
            );

            $skip = 0;

            foreach ($keywords as $key) {
                if (mb_strpos(mb_strtolower($p->description_ru), $key) !== false) $skip = 1;
                if (mb_strpos(mb_strtolower($p->name_ru), $key) !== false) $skip = 1;
            }

            if ($skip == 1) {
                $skipPics++;
                //echo 'skip '.$p->name_ru.PHP_EOL;
                continue;
            }

            //if(0 < count(array_intersect(array_map('strtolower', explode(' ', $p->description_ru)), $keywords)))continue;
            //if(0 < count(array_intersect(array_map('strtolower', explode(' ', $p->name_ru)), $keywords)))continue;

            $textDescription = preg_replace("/(<iframe.+\/iframe>)|(<img.+>)/", "", $p->description_ru);
            $textDescription = ((string) htmlspecialchars(strip_tags($textDescription)));

            $offer = $offers->addChild('offer');
            $offer->addAttribute('id', $p->productID);
            //$offer->addAttribute('type', 'vendor.model');
            $offer->addAttribute('available', $p->in_stock > 0?'true':'false');
            $offer->addChild('price',$p->Price);
            if ($p->list_price > $p->Price) {
                $offer->addChild('oldprice',$p->list_price);
                $offer->addChild('enable_auto_discounts', 'true');
            }
            $offer->addChild('url',htmlspecialchars("http://rybalkashop.ru/shop/category?product=$p->productID&id=$p->categoryID&srcref=ymrkt"));
            $offer->addChild('currencyId','RUR');
            $offer->addChild('categoryId',$p->categoryID);
            $imgman = new ImageMan();
            //$offer->addChild('picture',!empty($p->pictures[0])?htmlspecialchars('http://rybalkashop.ru/img/cache'.$imgman->load(Yii::getAlias('@frontend/web/img').'/products_pictures/' . $p->pictures[0]->largest, '1000x1000', Yii::$app->settings->get('image', 'productEnlarged'), 'main', 'products')):null);
            $offer->addChild('picture',!empty($p->pictures[0])?'http://rybalkashop.ru/img/products_pictures/' . htmlspecialchars(urlencode($p->pictures[0]->largest)):null);
            $offer->addChild('store',$p->in_stock > $p->in_stock_provider?'true':'false');
            $offer->addChild('vendor',!empty($p->category->monufacturer)?ucfirst(htmlspecialchars($p->category->monufacturer)):null);
            $offer->addChild('name',htmlspecialchars($p->name_ru));
            $offer->addChild('sales_notes','Наличные, Налож.платеж, Банк.карты, Эл.деньги.');
            $offer->addChild('description', $textDescription);
            $offer->addChild('manufacturer_warranty', 'true');

            $attrTarget = $p;

            if (empty($attrTarget->attrs)) {
                $attrTarget = $p->canon;
            }

            if (!empty($attrTarget) && !empty($attrTarget->attrs)){
                foreach ($attrTarget->attrs as $attr){
                    $param = $offer->addChild('param', htmlspecialchars($attr->option_value_ru));
                    $pname = htmlspecialchars($attr->optionName);
                    if($pname == 'RUSIZE'){
                        $pname = 'Размер';
                    }
                    $param->addAttribute('name', $pname);
                    $param->addAttribute('unit', 'RU');
                }
            }

            echo $p->name_ru . " - ok\n";

            $count ++;
        }

        $file = Yii::getAlias('@frontend/web/market.xml');
        $dom->loadXML($xml->asXML());

        file_put_contents($file, $dom->saveXML());

        $this->actionTouchPrice();

        echo $count . PHP_EOL;
    }

    public function actionTouchPrice()
    {
        $file = Yii::getAlias('@frontend/web/market.xml');
        touch($file);
    }

    public function actionGenerateTagTasks()
    {
        $model = SCCategories::find()->all();
        $pack = new StackTaskPacks();
        $pack->name = "Отсутствуют теги конечных категорий";
        $pack->created_by = 1;
        $pack->created_at = time();
        $pack->save(false);
        foreach ($model as $m){
            if(!empty($m->tags) && !empty($m->monufacturer))continue;
            if($m->hasCategories) continue;
            $task = new StackTasks;
            $task->pack_id = $pack->id;
            $task->created_by = 1;
            $task->created_at = time();
            $task->assigned_to = 56;
            $task->object = SCCategories::className();
            $task->object_id = $m->categoryID;

            $fields = [];
            if(empty($m->tags)){
                $fields['tags'] = 'тэги';
            }

            if(empty($m->monufacturer)){
                $fields['monufacturer'] = 'производитель';
            }

            $task->json_fields = Json::encode($fields);
            $task->status = 0;
            $task->save(false);
        }
    }

    public function actionGenerateAllTags()
    {
        $query = new Query();
        $query->select(['tags'])->from('SC_categories');
        $model = $query->all();

        //$model = SCCategories::find()->select(['tags'])->all();
        $tags = [];
        foreach ($model as $m){
            $t = explode(',', $m['tags']);
            foreach($t as $tt){
                $tags[] = trim($tt);
            }
            //$tags[] = trim(str_replace(',','',$m['tags']));
        }
        $tags = array_unique($tags);

        foreach ($tags as $tag){
            if(empty(trim($tag)))continue;
            $key = Inflector::slug($tag);
            $key = str_replace(' ', '_', $key);
            $key = str_replace('/', '-', $key);

            $model = SCTags::find()->where(['slug'=>Inflector::slug($tag)])->one();
            echo Inflector::slug($tag).PHP_EOL;
            if(empty($model)){
                $model = new SCTags();
            }
            $model->name = mb_strtolower($tag);
            $model->slug = Inflector::slug($tag);
            $model->save();
        }
    }

    public function actionTranslink()
    {
        $model = SCSecondaryPagesLinks::find()->all();
        foreach ($model as $m) {

            if(!is_int($m->mon_marker)){
                $mon = SCMonufacturers::find()->where(['like','name',$m->mon_marker])->one();
                if(!empty($mon)){
                    $m->mon_marker = $mon->id;
                    $m->save(false);
                }

            }

        }
    }

    public function actionRefreshStatuses()
    {
        $models = SCOrders::find()->select(['orderID', 'statusID'])->where(['statusID'=>3])->all();
        $count = count($models);
        echo "ALL - $count".PHP_EOL;
        foreach ($models as $m){
            $uploader = new UtUploader();
            $id = $uploader->getStatus($m);
            if(!empty($id)){
                $m->statusID = $id;
                if($m->save(false)){
                    $count--;
                    echo $count.PHP_EOL;
                } else {
                    print_r($m->getErrors());
                    break;
                }
            }
        }
    }

    public function actionCheck()
    {
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        ini_set('default_socket_timeout', 200);

        $client = new \SoapClient($url,
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis',
                'trace' =>true,
                'cache_wsdl' => 0,
                'connection_timeout' => 200,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                'location' => str_replace('?wsdl', '', $url)
            ]
        );

        $ar = $client->insertOrder([
            'order'=>'{"orderID":94720,"customerID":34752,"order_time":"2018-01-30 09:30:05","customer_ip":"212.42.63.154","shipping_type":"\u0421\u0430\u043c\u043e\u0432\u044b\u0432\u043e\u0437 - \u0411\u0440\u0430\u0442\u0438\u0441\u043b\u0430\u0432\u0441\u043a\u0430\u044f","shipping_module_id":0,"payment_type":"\u041d\u0430\u043b\u0438\u0447\u043d\u044b\u0435","payment_module_id":0,"customers_comment":"\u041f\u0440\u043e\u0441\u044c\u0431\u0430 \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044e \u043e \u0433\u043e\u0442\u043e\u0432\u043d\u043e\u0441\u0442\u0438 \u0437\u0430\u043a\u0430\u0437\u0430 \u043a \u0441\u0430\u043c\u043e\u0432\u044b\u0432\u043e\u0437\u0443 \u0441\u043a\u0438\u043d\u0443\u0442\u044c \u043d\u0430 \u043f\u043e\u0447\u0442\u0443","statusID":2,"shipping_cost":0,"order_discount":0,"discount_description":"\u041d\u0435\u0442","order_amount":"3496.00","currency_code":"RUR","currency_value":1,"customer_firstname":"\u042e\u0440\u0438\u0439","customer_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","customer_email":"manyura202@mail.ru","shipping_firstname":"\u042e\u0440\u0438\u0439","shipping_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","shipping_country":"\u0420\u043e\u0441\u0441\u0438\u044f","shipping_state":"\u041c\u043e\u0441\u043a\u0432\u0430","shipping_zip":"117525","shipping_city":null,"shipping_address":"\u041c\u043e\u0441\u043a\u0432\u0430 \u0427\u0435\u0440\u0442\u0430\u043d\u043e\u0432\u0441\u043a\u0430\u044f 13","billing_firstname":"\u042e\u0440\u0438\u0439","billing_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","billing_country":"\u0420\u043e\u0441\u0441\u0438\u044f","billing_state":"\u041c\u043e\u0441\u043a\u0432\u0430","billing_zip":"117525","billing_city":"\u041c\u043e\u0441\u043a\u0432\u0430","billing_address":"\u041c\u043e\u0441\u043a\u0432\u0430 \u0427\u0435\u0440\u0442\u0430\u043d\u043e\u0432\u0441\u043a\u0430\u044f 13","cc_number":null,"cc_holdername":null,"cc_expires":null,"cc_cvv":null,"affiliateID":null,"shippingServiceInfo":null,"google_order_number":"","source":"storefront","id_1c":null,"user_phone":"+7 (916) 136-3625","manager_id":null,"manager_1c_id":null,"certificate_id":null,"source_ref":null,"customer_patronname":"","payed":null}',
            'items'=> '[{"itemID":663421,"orderID":94720,"name":"F0000060851","Price":3496,"Quantity":1,"tax":0,"load_counter":0,"1c_id":null,"DefaultPrice":3,"Discount":10}]',
            'customer' => '{"customerID":34752,"Login":"yura545","cust_password":"eXVyYTEzNjM2MjU=","Email":"manyura202@mail.ru","first_name":"\u042e\u0440\u0438\u0439","last_name":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","subscribed4news":1,"custgroupID":3,"addressID":0,"reg_datetime":"2016-09-06 18:08:01","CID":0,"affiliateID":0,"affiliateEmailOrders":0,"affiliateEmailPayments":0,"ActivationCode":"","vkontakte_id":0,"keyword":"","1c_id":"F00028095","changed":0,"user_id":3014,"city":null,"street":null,"house":null,"zip":null,"phone":"+7 (916) 136-3625","rebuilt":null,"reset_id_1c":null}'
        ]);

        print_r($ar->return);
    }

    public function actionCheckTwo()
    {
        $soapUrl = "http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl"; // asmx URL of WSDL
        $soapUser = "siteabserver";  //  username
        $soapPassword = "revresbaetis"; // password

        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:x="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sit="http://89.223.24.77/srv/sitesync">
                            <x:Header/>
                            <x:Body>
                                <sit:insertOrder>
                                    <sit:order>{"orderID":94720,"customerID":34752,"order_time":"2018-01-30 09:30:05","customer_ip":"212.42.63.154","shipping_type":"\u0421\u0430\u043c\u043e\u0432\u044b\u0432\u043e\u0437 - \u0411\u0440\u0430\u0442\u0438\u0441\u043b\u0430\u0432\u0441\u043a\u0430\u044f","shipping_module_id":0,"payment_type":"\u041d\u0430\u043b\u0438\u0447\u043d\u044b\u0435","payment_module_id":0,"customers_comment":"\u041f\u0440\u043e\u0441\u044c\u0431\u0430 \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044e \u043e \u0433\u043e\u0442\u043e\u0432\u043d\u043e\u0441\u0442\u0438 \u0437\u0430\u043a\u0430\u0437\u0430 \u043a \u0441\u0430\u043c\u043e\u0432\u044b\u0432\u043e\u0437\u0443 \u0441\u043a\u0438\u043d\u0443\u0442\u044c \u043d\u0430 \u043f\u043e\u0447\u0442\u0443","statusID":2,"shipping_cost":0,"order_discount":0,"discount_description":"\u041d\u0435\u0442","order_amount":"3496.00","currency_code":"RUR","currency_value":1,"customer_firstname":"\u042e\u0440\u0438\u0439","customer_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","customer_email":"manyura202@mail.ru","shipping_firstname":"\u042e\u0440\u0438\u0439","shipping_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","shipping_country":"\u0420\u043e\u0441\u0441\u0438\u044f","shipping_state":"\u041c\u043e\u0441\u043a\u0432\u0430","shipping_zip":"117525","shipping_city":null,"shipping_address":"\u041c\u043e\u0441\u043a\u0432\u0430 \u0427\u0435\u0440\u0442\u0430\u043d\u043e\u0432\u0441\u043a\u0430\u044f 13","billing_firstname":"\u042e\u0440\u0438\u0439","billing_lastname":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","billing_country":"\u0420\u043e\u0441\u0441\u0438\u044f","billing_state":"\u041c\u043e\u0441\u043a\u0432\u0430","billing_zip":"117525","billing_city":"\u041c\u043e\u0441\u043a\u0432\u0430","billing_address":"\u041c\u043e\u0441\u043a\u0432\u0430 \u0427\u0435\u0440\u0442\u0430\u043d\u043e\u0432\u0441\u043a\u0430\u044f 13","cc_number":null,"cc_holdername":null,"cc_expires":null,"cc_cvv":null,"affiliateID":null,"shippingServiceInfo":null,"google_order_number":"","source":"storefront","id_1c":null,"user_phone":"+7 (916) 136-3625","manager_id":null,"manager_1c_id":null,"certificate_id":null,"source_ref":null,"customer_patronname":"","payed":null}</sit:order>
                                    <sit:items>[{"itemID":663421,"orderID":94720,"name":"F0000060851","Price":3496,"Quantity":1,"tax":0,"load_counter":0,"1c_id":null,"DefaultPrice":3,"Discount":10}]</sit:items>
                                    <sit:customer>{"customerID":34752,"Login":"yura545","cust_password":"eXVyYTEzNjM2MjU=","Email":"manyura202@mail.ru","first_name":"\u042e\u0440\u0438\u0439","last_name":"\u041c\u0430\u043d\u0441\u0443\u0440\u043e\u0432","subscribed4news":1,"custgroupID":3,"addressID":0,"reg_datetime":"2016-09-06 18:08:01","CID":0,"affiliateID":0,"affiliateEmailOrders":0,"affiliateEmailPayments":0,"ActivationCode":"","vkontakte_id":0,"keyword":"","1c_id":"F00028095","changed":0,"user_id":3014,"city":null,"street":null,"house":null,"zip":null,"phone":"+7 (916) 136-3625","rebuilt":null,"reset_id_1c":null}</sit:customer>
                                </sit:insertOrder>
                            </x:Body>
                        </soap:Envelope>';

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice",
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch);
            curl_close($ch);

            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);



            echo $response;
    }

    public function actionAddParental()
    {
        $models = SCCategories::find()->where(['like', 'tags', 'троллинг'])->all();
        foreach($models as $m){
            $n = new SCRelatedCategories();
            $n->categoryID = 104320;
            $n->relatedCategoryID = $m->getPrimaryKey();
            $n->save();
            /*$p = new SCParentalConnections();
            $p->parent = 104320;
            $p->categoryID = $m->getPrimaryKey();
            $p->save(false);*/
            /*SCParentalConnections::deleteAll(['parent'=>104320, 'categoryID'=>$m->getPrimaryKey()]);*/
        }
    }

    public function actionReset()
    {
        $model = SCCategories::find()->where(['parent'=>124702])->all();
        foreach($model as $m){
            $m->resetMeta();
            $m->resetCache();
        }
    }

    public function actionBuildMongo(){
        $products = SCProducts::find()->select(['productID','categoryID','name_ru','Price','list_price','maxDiscount','in_stock','in_stock_provider','description_ru','upload2market'])->all();
        $c = count($products);
        $i = 0;
        foreach ($products as $product){
            $i++;
            echo "product $i of $c".PHP_EOL;
            if(!empty(ProductInfo::find()->where(['product_id'=>$product->productID])->one())) continue;
            $mo = new ProductInfo();
            $mo->product_id = $product->productID;
            $mo->category_id = $product->categoryID;
            $mo->name = $product->name_ru;
            $mo->price = $product->Price;
            $mo->old_price = $product->list_price;
            $mo->discount_percent = $product->maxDiscount;
            $mo->in_stock = $product->in_stock;
            $mo->in_stock_provider = $product->in_stock_provider;
            $mo->monufacturer = !empty($product->category->monufacturer)?ucfirst(htmlspecialchars($product->category->monufacturer)):null;
            $mo->description = $product->description_ru;
            $mo->pictures = SCProductPictures::find()->where("productID = $product->productID")->orderBy('priority')->asArray()->all();
            $mo->market = $product->upload2market == 1?true:false;
            $attrs = [];
            $attrTarget = $product;
            if (empty($attrTarget->attrs)) {
                $attrTarget = $product->canon;
            }

            if (!empty($attrTarget) && !empty($attrTarget->attrs)){
                foreach ($attrTarget->attrs as $attr){
                    $pname = htmlspecialchars($attr->optionName);
                    if($pname == 'RUSIZE'){
                        $pname = 'Размер';
                    }
                    $attrs[] = ['name'=>$pname, 'value'=>$attr->option_value_ru, 'id'=>$attr->optionID];
                }
            }
            $mo->params = $attrs;
            $mo->save();
        }
    }

    public function actionBuildMongoAttrs(){
        $products = SCProducts::find()->all();

        $c = count($products);

        $i = 0;

        foreach ($products as $product) {
            echo "product " . ++$i . " of " . $c;

            if (!empty(ProductAttributes::find()->where(['product_id' => $product->productID])->one())) {
                echo " - запись СУЩЕСТВУЕТ" . PHP_EOL;
                continue;
            }

            $model = new ProductAttributes();

            $model->product_id = $product->productID;

            $attrs = [];

            $attrTarget = $product;

            if (empty($attrTarget->attrs)) {
                $attrTarget = $product->canon;
            }

            if (!empty($attrTarget) && !empty($attrTarget->attrs)) {
                foreach ($attrTarget->attrs as $attr) {
                    $pname = htmlspecialchars($attr->optionName);

                    if ($pname == 'RUSIZE') {
                        $pname = 'Размер';
                    }

                    $attrs[] = [
                        'name'  => $pname,
                        'value' => $attr->option_value_ru,
                        'id'    => $attr->optionID
                    ];
                }
            }

            $model->params = $attrs;

            $model->save();

            echo " - запись ДОБАВЛЕНА" . PHP_EOL;
        }
    }

    public function actionBuildMongoCats()
    {
        $cats = SCCategories::find()->select(['categoryID','name_ru','parent', 'description_ru','picture'])->all();
        foreach ($cats as $cat){
            $cat->buildLinkage();
        }
    }

    public function actionLoadPaths()
    {
        $cats = SCCategories::find()->where(["cat_path"=>null])->all();
        foreach($cats as $cat){
            $path = array();

            $id = $cat->categoryID;
            $parent = $cat->parent;

            $path[] = $id;

            while ($parent <> 1) {
                $model = SCCategories::find()->where(['categoryID' => $parent])->one();
                if (empty($model)) break;
                $parent = $model->parent;
                $id = $model->categoryID;
                $path[] = $id;
            }

            $cat->cat_path = Json::encode(array_reverse($path));
            $cat->save();
        }
    }

    public function actionLoadPathsProduct()
    {
        $models = SCProducts::find()->select(['productID', 'c_cat_path'=>'SC_categories.cat_path'])->leftJoin("SC_categories", "SC_categories.categoryID = SC_products.categoryID")->all();
        //print_r($models);
        foreach($models as $m){
            $cp = Json::decode($m['c_cat_path']);
            $m->cat_path = $cp;
            $m->save();
        }
    }

    public function actionBuildCodeCache(){
        $models = SCProducts::find()->select(['productID','product_code'])->all();
        $cache = Yii::$app->cache;
        $begin = time();
        $count = count($models);
        $i = 0;
        foreach($models as $m){
            $i++;
            $key = 'product_by_code_'.$m->product_code;
            $model = $cache->get($key);
            if($model !== false){
                $model = SCProducts::find()->where(['product_code'=>$m->product_code])->one();
                $cache->set($key, $model);
            }
            echo "doing $i/$count".PHP_EOL;

        }
        $end = time();
        $diff = $end - $begin;
        echo 'done in '.$diff.' seconds'.PHP_EOL;
    }
}
