<?php

namespace frontend\models;

use yii\base\Model;
use frontend\components\validators\PhoneValidator;

/**
 * ContactForm is the model behind the contact form.
 */
class OrderingFormQuick extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $phonecode;
    public $email;
    public $shipping;

    public $orderID;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'phonecode', 'email', 'shipping'], 'required'],
            [['first_name', 'last_name', 'phone', 'phonecode'], 'string'],

            [['email'], 'trim'],
            [['email'], 'email'],

            ['phone', PhoneValidator::className()],

            ['shipping', 'exist', 'targetClass' => 'common\models\SCShippingMethods', 'targetAttribute' => 'SID'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'phone' => 'Телефон',
            'shipping' => 'Способ доставки',
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
