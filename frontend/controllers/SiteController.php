<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\caching\TagDependency;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use common\models\mongo\CategoryInfo;
use common\models\mongo\ProductInfo;
use common\models\SCOrders;
use common\models\SubscribedMails;
use common\models\LoginForm;
use frontend\models\ErrorForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    use AjaxValidationTrait;
    use EventTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            /*'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'cache' => 'dbCache',
                'only' => ['index'],
                'duration' => 86400,
                'variations' => [
                    \Yii::$app->user->can('alphaTester'),
                    \Yii::$app->user->can('Employee'),
                    \Yii::$app->user->isGuest,
                    !empty(\Yii::$app->user->identity->customer->card) ? \Yii::$app->user->identity->customer->card : null,
                ],
                'enabled' => Yii::$app->request->isGet
                
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'frontend\actions\CaptchaAction',
                'foreColor'=>'15282738',
                'fontFile'=>'@frontend/web/captcha5.ttf',
                'minLength'=>5,
                'maxLength'=>9,
                'transparent'=>true,
            ],
            'thumb' => 'frontend\actions\ThumbAction',
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //Yii::$app->db->schema->refresh();
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = \Yii::createObject(LoginForm::className());

        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            return $this->goBack();
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionElements()
    {
        return $this->render('elements');
    }

    public function actionCdekMap()
    {
        //return $this->renderPartial('cdekmap');
    }

    public function actionSubscribe()
    {
        $model = new SubscribedMails;
        if ($model->load(Yii::$app->request->post())){
            if($model->save()){
                Yii::$app->session->setFlash('notify', ['msg'=>'Email успешно подписан на новости!', 'icon'=>'fa fa-check']);
            } else {
                Yii::$app->session->setFlash('notify', ['msg'=>$model->getFirstError('email'), 'icon'=>'fa fa-exclamation']);
            }
        }

        return $this->goBack();
    }

    public function actionUnsubscribe($token){
        $model = SubscribedMails::find()->where(['unsubscribehash'=>$token])->one();
        if(!empty($model)){
            $model->delete();
            Yii::$app->session->setFlash('notify', ['msg'=>'Вы успешно отписались от рассылки!', 'icon'=>'fa fa-check']);
        }
        $this->redirect('/');
    }

    public function actionMailtest()
    {
        $user = Yii::$app->user->identity;
        $order = SCOrders::findOne(55195);
        $this->layout = "@frontend/views/mail/layouts/html";
        return $this->render('@frontend/views/mail/order', ['order'=>$order]);
    }

    public function actionSendError()
    {
        $model = new ErrorForm();
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            Yii::$app->session->setFlash('notify', ['msg'=>'Сообщение успешно отправлено!', 'icon'=>'fa fa-check']);
            Yii::$app->bot->sendMessage(-14068578, "Отправлено сообщение об ошибке! ".$model->text);
        } else {
            print_r($model->getErrors());
            return;
        }

        return $this->goBack();
    }

    public function actionSitemap($type = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');

        $view = 'sitemap';
        if($type == 'categories'){
            $view = 'sitemap_categories';
        }
        if($type == 'products'){
            $view = 'sitemap_products';
        }
        if($type == 'products2'){
            $view = 'sitemap_products2';
        }
        if($type == 'products3'){
            $view = 'sitemap_products3';
        }
        if($type == 'news'){
            $view = 'sitemap_news';
        }
        return $this->renderPartial('sitemaps/'.$view);
    }

    public function actionReloadMe()
    {

        //return null;

        $ar = [];
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



        foreach ($ar as $a){
            $login = $a['login'];
            $password = $a['password'];
            $name = $a['name'];
            $shop = $a['shop'];


            echo "
            <div style='height:100vh;text-align:center;display: flex;flex-wrap: wrap;align-items: center;justify-content: center;'>
                <div>
                <h1 style='width: 100%'>$name</h1>
                <h2 style='width: 100%'>$shop</h2>
                <p style='width: 100%'>Логин: $login</p>
                <p style='width: 100%'>Пароль: $password</p>
                </div>
</div>
            ";
        }
    }

    public function actionYandex()
    {
        header("Content-Type: application/xml; charset=utf-8");
        //$models = ProductInfo::find()->where(['market'=>true])->all();
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $date = Yii::$app->settings->get('market', 'lastupdate');
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


        $cats = CategoryInfo::find()->all();
        foreach ($cats as $c){
            $category = $categories->addChild('category', htmlspecialchars($c->name));
            $category->addAttribute('id', $c->category_id);
            $category->addAttribute('parentId', $c->parent);
        }

        $products = ProductInfo::find()->where(['market'=>true])->all();
        $count = 0;

        $skipWOPrice = 0;
        $skipStock = 0;
        $skipPics = 0;
        $skipStops = 0;


        foreach ($products as $p){
            if($p->price <= 0){
                $skipWOPrice++;
                continue;
            }
            if($p->in_stock <= 0){
                $skipStock++;
                continue;
            }
            if(empty($p->pictures[0])){
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

            foreach ($keywords as $key){
                if (mb_strpos(mb_strtolower($p->description), $key) !== false)$skip = 1;
                if (mb_strpos(mb_strtolower($p->name), $key) !== false)$skip = 1;
            }

            if($skip == 1){
                $skipPics++;
                //echo 'skip '.$p->name_ru.PHP_EOL;
                continue;
            }

            //if(0 < count(array_intersect(array_map('strtolower', explode(' ', $p->description_ru)), $keywords)))continue;
            //if(0 < count(array_intersect(array_map('strtolower', explode(' ', $p->name_ru)), $keywords)))continue;

            $offer = $offers->addChild('offer');
            $offer->addAttribute('id', $p->product_id);
            //$offer->addAttribute('type', 'vendor.model');
            $offer->addAttribute('available', $p->in_stock > 0?'true':'false');
            $offer->addChild('price',$p->price);
            if($p->old_price > $p->price){
                $offer->addChild('oldprice',$p->old_price);
            }
            $offer->addChild('url',htmlspecialchars("http://rybalkashop.ru/shop/category?product=$p->product_id&id=$p->category_id&srcref=ymrkt"));
            $offer->addChild('currencyId','RUR');
            $offer->addChild('categoryId',$p->category_id);
            //$imgman = new ImageMan();
            //$offer->addChild('picture',!empty($p->pictures[0])?htmlspecialchars('http://rybalkashop.ru/img/cache'.$imgman->load(Yii::getAlias('@frontend/web/img').'/products_pictures/' . $p->pictures[0]->largest, '1000x1000', Yii::$app->settings->get('image', 'productEnlarged'), 'main', 'products')):null);
            $offer->addChild('picture',!empty($p->pictures[0])?'http://rybalkashop.ru/img/products_pictures/' . htmlspecialchars(urlencode($p->pictures[0]['filename'])):null);
            $offer->addChild('store',$p->in_stock > $p->in_stock_provider?'true':'false');
            $offer->addChild('vendor',!empty($p->monufacturer)?ucfirst(htmlspecialchars($p->monufacturer)):null);
            $offer->addChild('name',htmlspecialchars($p->name));
            $offer->addChild('sales_notes','Минимальная сумма заказа: 1000 руб.');
            $offer->addChild('description',((string) htmlspecialchars(strip_tags($p->description))));

            foreach ($p->params as $attr){
                $param = $offer->addChild('param', htmlspecialchars($attr['value']));
                $pname = htmlspecialchars($attr['name']);
                $param->addAttribute('name', $pname);
                $param->addAttribute('unit', 'RU');
            }

        }



        //$file = Yii::getAlias('@frontend/web/market.xml');
        $dom->loadXML($xml->asXML());

        return $dom->saveXML();

        //echo $count.PHP_EOL;
    }

    public function actionTestMail()
    {
        $order = SCOrders::findOne(112798);
        return $this->render('/mail/status_change', ['order'=>$order]);
    }

    public function actionShwabra(){
        return false;
    }

    public function actionReset(){
        if(Yii::$app->user->can('headField')){
            TagDependency::invalidate(Yii::$app->cache, 'extra_prices');
        }
    }
}
