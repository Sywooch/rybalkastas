<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_customers".
 *
 * @property integer $customerID
 * @property string $Login
 * @property string $cust_password
 * @property string $Email
 * @property string $first_name
 * @property string $last_name
 * @property string $house
 * @property string $flat
 * @property integer $subscribed4news
 * @property integer $custgroupID
 * @property integer $addressID
 * @property string $reg_datetime
 * @property integer $CID
 * @property integer $affiliateID
 * @property integer $affiliateEmailOrders
 * @property integer $affiliateEmailPayments
 * @property string $ActivationCode
 * @property integer $vkontakte_id
 * @property string $keyword
 * @property string $1c_id
 * @property integer $changed
 * @property string $1c_id
 * @property int $user_id
 * @property int $city
 * @property string $street
 * @property string $zip
 * @property string $phone
 * @property int $rebuilt
 * @property string $reset_id_1c
 * @property string $1c_id
 */
class SCCustomers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_customers';
    }

    /**
     * @return \yii\db\Connection|Object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscribed4news', 'custgroupID', 'addressID', 'CID', 'affiliateID', 'affiliateEmailOrders', 'affiliateEmailPayments', 'vkontakte_id', 'changed', 'user_id', 'city', 'rebuilt'], 'integer'],
            [['user_id', 'Login'], 'unique'],
            [['reg_datetime'], 'safe'],
            [['Login', 'first_name', 'last_name'], 'string', 'max' => 32],
            [['cust_password', 'keyword', '1c_id', 'street', 'house', 'flat', 'zip','phone', 'reset_id_1c'], 'string', 'max' => 255],
            [['Email'], 'string', 'max' => 64],
            [['ActivationCode'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerID' => 'Customer ID',
            'Login' => 'Login',
            'cust_password' => 'Cust Password',
            'Email' => 'Email',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'subscribed4news' => 'Subscribed4news',
            'custgroupID' => 'Custgroup ID',
            'addressID' => 'Address ID',
            'reg_datetime' => 'Reg Datetime',
            'CID' => 'Cid',
            'affiliateID' => 'Affiliate ID',
            'affiliateEmailOrders' => 'Affiliate Email Orders',
            'affiliateEmailPayments' => 'Affiliate Email Payments',
            'ActivationCode' => 'Activation Code',
            'vkontakte_id' => 'Vkontakte ID',
            'keyword' => 'Keyword',
            '1c_id' => '1c ID',
            'changed' => 'Changed',
            'phone' => 'Телефон',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'flat' => 'Квартира',
            'zip' => 'Индекс',
        ];
    }

    public function getRegfields(){
        $data = array();

        $fields = SCCustomerRegFields::find()->all();

        foreach($fields as $f){
            $val = SCCustomerRegFieldsValues::find()
                ->where("customerID = $this->customerID AND reg_field_ID = $f->reg_field_ID")
                  ->one();

            $data[] = [
                'name'  => $f->reg_field_name_ru,
                'value' => (!empty($val) ? $val->reg_field_value : '')
            ];
        }

        return $data;
    }

    public function getOrders(){
        $email = $this->user->email;

        $model = SCOrders::find()
              ->where("customerID = $this->customerID")
            ->orWhere(['customer_email'=>$email])
            ->orderBy('orderID DESC')
                ->all();

        return $model;
    }

    public function getOrderSummary(){
        $statuses = SCOrderStatus::find()->all();

        $data = array();

        foreach($statuses as $s){
            $amount = SCOrders::find()
                  ->where("customerID = $this->customerID AND statusID = $s->statusID")
                ->orderBy('orderID DESC')
                    ->sum("order_amount");

            if ($amount <= 0) continue;

            $data[] = ['status' => $s->status_name_ru, 'amount' => $amount, 'color' => $s->color];
        }

        return $data;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCard()
    {
        return $this->hasOne(SCCards::className(), ['customerID' => 'customerID']);
    }

    public function getRequestedProducts()
    {
        return $this->hasMany(SCProducts::className(), ['productID' => 'productID'])
            ->viaTable('SC_product_request', ['customerID' => 'customerID'])
             ->orderBy(['in_stock' => SORT_DESC]);
    }

    public function getRequestedCount()
    {
        return $this->hasMany(SCProducts::className(), ['productID' => 'productID'])
            ->viaTable('SC_product_request', ['customerID' => 'customerID'])
               ->where(['>', 'in_stock', 0])
               ->count();
    }
}
