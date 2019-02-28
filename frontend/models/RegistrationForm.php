<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 03.04.2017
 * Time: 9:49
 */

namespace frontend\models;

use common\models\SCCustomers;
use dektrium\user\models\Profile;
use frontend\models\RegistrationFormDefault as BaseRegistrationForm;
use common\models\User;
use yii\helpers\Json;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $first_name;
    public $last_name;
    public $phone;
    public $city;
    public $street;
    public $house;
    public $zip;

    public $accept_policy;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['first_name', 'last_name','phone'/*, 'city','street','house','zip'*/], 'required'];
        $rules[] = [['first_name', 'last_name','phone', 'street','house','zip'], 'string', 'max' => 255];
        $rules[] = ['city', 'exist', 'targetClass'=>'common\models\SCCities', 'targetAttribute'=>'cityID'];
        //$rules[] = [['accept_policy'], 'required', 'message' => 'Для продолжения необходимо отметить данное поле'];
        $rules[] = [['accept_policy'], 'boolean'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['first_name'] = \Yii::t('user', 'Имя');
        $labels['last_name'] = \Yii::t('user', 'Фамилия');
        $labels['phone'] = \Yii::t('user', 'Номер телефона');
        $labels['city'] = \Yii::t('user', 'Город');
        $labels['street'] = \Yii::t('user', 'Улица');
        $labels['house'] = \Yii::t('user', 'Дом');
        $labels['zip'] = \Yii::t('user', 'Почтовый индекс');
        $labels['accept_policy'] = "";
        return $labels;
    }

    public function register($customer = null)
    {

        if (!$this->validate()) {
            \Yii::$app->bot->sendMessage(-14068578, Json::encode($this->getErrors()));

            return false;
        }

        /** @var User $user */
        $user = \Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user, $customer);

        if (!$user->register()) {
            return false;
        }

        \Yii::$app->session->setFlash(
            'info',
            \Yii::t(
                'user',
                'Your account has been created and a message with further instructions has been sent to your email'
            )
        );
        try {
            $mailer = \Yii::$app->mailer_s;
            //$mailer->
            $mail = $mailer->compose(['html'=>'@frontend/views/mail/welcome'],[])
                ->setFrom(['contacts@rybalkashop.ru' => 'Rybalkashop.ru Рыболов на "Птичке"']);
            $mail->setTo($user->email);
            $mail->setSubject("Успешная регистрация на сайте");
            $mail->send();
        } catch (\Exception $e){
            \Yii::$app->bot->sendMessage(-14068578, "Пользователю $this->email не отправлено письмо при регистрации!");
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes($user, $customer = null)
    {

        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $this->first_name.' '.$this->last_name,
        ]);
        $user->setProfile($profile);

        if(empty($customer)){
            $customer = \Yii::createObject(SCCustomers::className());
            $customer->setAttributes([
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'city'=>$this->city,
                'street'=>$this->street,
                'house'=>$this->house,
                'zip'=>$this->zip,
                'phone'=>$this->phone
            ]);
        }

        $user->setCustomer($customer);

    }
}