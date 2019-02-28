<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 02.11.2015
 * Time: 12:03
 */

namespace backend\controllers;

use backend\models\MailerForm;
use common\models\MailForm;
use common\models\Mails;
use common\models\SCCustomers;
use common\models\SubscribedMails;
use common\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\validators\EmailValidator;
use common\models\SCCustomerRegFieldsValues;

class MailController extends Controller
{

    public function actionIndex(){
        ini_set('max_execution_time', 1000000);


        $model = new MailerForm();
        $em = new EmailValidator();

        if ($model->load(Yii::$app->request->post())) {
            if($model->test == 1){
                $all = [
                    ['email'=>'denvolin@gmail.com', 'hash'=>md5(uniqid().time())],
                    ['email'=>'fugu_25-17@mail.ru', 'hash'=>md5(uniqid().time().'1')],
                    ['email'=>'surax17@gmail.com', 'hash'=>md5(uniqid().time().'3')],
                    ['email'=>'mos_fishing@mail.ru', 'hash'=>md5(uniqid().time().'4')],
                    ['email'=>'na-ptichke@yandex.ru', 'hash'=>md5(uniqid().time().'5')],
                    ['email'=>'naptichke@mail.ru', 'hash'=>md5(uniqid().time().'5')],
                ];
            } else {
                $users = SubscribedMails::find()->all();
                $all = [];
                foreach($users as $u){
                    if($em->validate($u->email)){
                        $all[] = ['email'=>$u->email, 'hash'=>$u->unsubscribehash];
                    }
                }
            }
            $time = time();
            $key = base64_encode('RYBALKASHOPRU'.$time.'RYBALKASHOPRU');

            $innerMails = [
                'news@mail.rybalkashop.ru'=>'Rybalkashop<news@mail.rybalkashop.ru>',
                'actions@mail.rybalkashop.ru'=>'Акции Rybalkashop<actions@mail.rybalkashop.ru>',
                'mailer@mail.rybalkashop.ru'=>'Рассылка Rybalkashop<mailer@mail.rybalkashop.ru>',
                'administration@mail.rybalkashop.ru'=>'Администрация Rybalkashop<administration@mail.rybalkashop.ru>'
            ];

            $from = $innerMails[$model->from];

            foreach($all as $a){
                $email = $a['email'];
                $hash = $a['hash'];
                $rcontent = str_replace('{UNSUBSCRIBETOKENLINK}', 'http://rybalkashop.ru/site/unsubscribe?token='.$hash, $model->content);
                $content = $model->subject.PHP_EOL.$from.PHP_EOL.$hash.PHP_EOL.$rcontent;
                $url = 'http://165.227.145.160/loader.php';
                $data = array('time' => $time, 'key' => $key, 'mail'=>$email, 'content'=>mb_convert_encoding($content, 'UTF-8'));

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
        } else {
            $model->subject = "Новости Rybalkashop";
        }
        //if($model->load())

        return $this->render('index',['model'=>$model]);
    }

}