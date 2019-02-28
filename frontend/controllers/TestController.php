<?php
namespace frontend\controllers;

use common\models\SCProductRequest;
use common\models\SCProducts;
use common\models\SCSecondaryPages;
use common\models\ut\Nomenclature;
use yii\helpers\Json;
use yii\mongodb\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use SoapClient;
use yii\web\User;
use yii\web\View;

class TestController extends Controller
{

    public function actionIndex(){
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \mongosoft\soapclient\Client([
            'url' => $url,
            'options' =>
            [
                'login'=>'siteabserver',
                'password'=>'revresbaetis'
            ]
        ]);
        $ar = $client->loadOrders();
        $ars = json_decode($ar->return);
        print_r($ars);
    }

    public function actionTree()
    {

        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new SoapClient($url,
                [
                    'login'=>'siteabserver',
                    'password'=>'revresbaetis'
                ]
        );
        $ar = $client->loadTree(['parent'=>'F0000056493']);

        $ars = json_decode($ar->return);
        foreach ($ars as $a){
            $element = new Nomenclature($a);
            echo $element->name.' '.$element->isLoaded.'<br/>';
        }
        //print_r($ars);
    }

    public function actionCheck()
    {
        $url = 'http://89.223.24.77/srv/utbase/ws/sitesync.1cws?wsdl';
        //echo file_get_contents($url);

        $client = new \mongosoft\soapclient\Client([
            'url' => $url,
            'options' =>
                [
                    'login'=>'siteabserver',
                    'password'=>'revresbaetis'
                ]
        ]);
        $ar = $client->__getFunctions();
        print_r($ar);
    }

    public function actionMong()
    {
        $query = new Query();
        $result = $query->from('tasks')->all();
        print_r($result);
    }

    public function actionPayment()
    {
        return $this->render('payment');
    }

    public function actionShipping()
    {
        return $this->render('shipping');
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionAbout()
    {
        $data = [
            'order_id'=>000001,
            'price'=>12000,
            'payment_sum'=>12300,
            'delivery_sum'=>300,
            'shop'=>[
                'name'=>'99821'
            ],
            'customer'=>[
                'fio'=>'Иванов Иван Иванович',
                'address'=>'Альбион, 22',
                'phone'=>'+78889990011'
            ],
            'items'=>[
                [
                    'id'=>'12312',
                    'name'=>'Товар',
                    'price'=>3000,
                    'quantity'=>4
                ]
            ],
            'weights'=>[
                'weight'=>'12',
                'barcode'=>'123123012030',
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.boxberry.de/json.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'token'=>'58978.pnpqdfee',
            'method'=>'ParselCreate',
            'sdata'=>Json::encode($data)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $datares = Json::decode(curl_exec($ch),1);
        print_r($datares);
    }

    public function actionMail(){
        $user = Yii::$app->user->identity;
        $mailer = \Yii::$app->getMailer();
        //$mailer->
        $mail = $mailer->compose(['html'=>'@frontend/views/mail/welcome'],[])
            ->setFrom(['support@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
        $mail->setTo($user->email);
        $mail->setSubject("Успешная регистрация на сайте");
        $mail->send();
    }

    public function actionCreateMails(){
        $time = time();
        $key = base64_encode('RYBALKASHOPRU'.$time.'RYBALKASHOPRU');
        $this->layout = '///mail/html';

        $model = \common\models\User::find()->where(['like', 'email', 'rybalkashop'])->orWhere(['email'=>'denvolin@gmail.com'])->all();

        foreach ($model as $m){
            $email = $m->email;
            $content = $this->render('//mail/welcome');
            $url = 'http://mail.rybalkashop.ru/loader.php';
            $data = array('time' => $time, 'key' => $key, 'mail'=>$email, 'content'=>$content);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { /* Handle error */ }

            var_dump($result);
        }

    }

    public function actionRemeta()
    {
        $model = SCProducts::findOne(463013);
        $model->name_ru = str_replace("%",'',$model->name_ru);
        $model->save();
    }

    public function actionPushAwaiting()
    {
        $user = Yii::$app->user->identity->customer->customerID;
        $products = SCProducts::find()->orderBy('RAND()')->limit(20)->all();
        foreach($products as $p){
            $m = new SCProductRequest();
            $m->productID = $p->productID;
            $m->customerID = $user;
            $m->save();
        }
    }

}