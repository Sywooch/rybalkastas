<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\SCExperts;
use frontend\components\validators\PhoneValidator;

/**
 * ContactForm is the model behind the contact form.
 * @property $className string
 */
class OrderingForm extends Model
{
    public $first_name;
    public $last_name;
    public $patron_name;
    public $email;
    public $subscribe_for_news;
    public $phone;
    public $phonecode;
    public $city;
    public $street;
    public $house;
    public $flat;
    public $zip;
    public $country;
    public $comment;
    public $manager;
    //public $captcha;
    
    public $shipping;
    public $payment;

    public $orderID; //FOR AFTER USE
    public $accept_policy; //FOR AFTER USE

    public $boxberry_info;

    private $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/u';
    private $nameRegexp     = '/^[-a-zA-Zа-яёА-ЯЁ0-9_\.@]+$/u';
    private $houseRegexp    = '/^[-a-zA-Zа-яёА-ЯЁ0-9_\/.@]+$/u';

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone', 'phonecode', 'street','house','city', 'shipping', 'payment', 'zip'], 'required'],
            [['first_name', 'last_name', 'phone', 'phonecode', 'street', 'house', 'flat', 'city', 'comment', 'patron_name'], 'string'],

            [['house', 'flat', 'first_name','last_name'], 'trim'],

            [['email'], 'trim'],
            [['email'], 'email'],

            [['first_name', 'last_name'], 'match', 'pattern' => $this->nameRegexp],
            [['house', 'flat'],           'match', 'pattern' => $this->houseRegexp],


            ['manager', 'in', 'range' => ArrayHelper::getColumn(SCExperts::find()->all(),'expert_id')],

            ['shipping', 'exist', 'targetClass' => 'common\models\SCShippingMethods', 'targetAttribute' => 'SID'],
            ['payment',  'exist', 'targetClass' => 'common\models\SCPaymentTypes',    'targetAttribute' => 'PID'],

            ['phone', PhoneValidator::className()],

            //[['captcha'], 'captcha'],

            [['accept_policy'], 'boolean'],
            [['zip'], 'integer'],

            /*[['captcha'], 'required', 'when' => function($model) {
                return Yii::$app->user->isGuest;
            }],*/
            [['patron_name'], 'required', 'when' => function($model) {
                return $model->shipping == 31;
            }, 'whenClient' => "function (attribute, value) {
              return $('#shipping_id').val() == 31;
            }"],
            [['boxberry_info'], 'required', 'when' => function($model) {
                return $model->shipping == 34;
            }, 'whenClient' => "function (attribute, value) {
              return $('#shipping_id').val() == 34;
            }"],

            ['manager', 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patron_name' => 'Отчество',
            'email' => 'Email',
            'phone' => 'Телефон',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'flat' => 'Квартира',
            'comment' => 'Комментарий',
            'shipping' => 'Способ доставки',
            'payment' => 'Способ оплаты',
            'manager' => 'Менеджер',
            'captcha' => 'Введите символы с изображения',
            'accept_policy' => '',
            'zip' => 'Почтовый индекс',
            'boxberry_info' => 'Пункт самовывоза Boxberry'
        ];
    }

    public function greaterThanOne($attribute, $params)
    {
        if ($this->$attribute < 1) $this->addError($attribute, 'Нельзя добавить меньше 1 позиции');
    }

    public function getClassName() : string
    {
        $fullNameElements = explode("\\", __CLASS__);

        return end($fullNameElements);
    }
}
