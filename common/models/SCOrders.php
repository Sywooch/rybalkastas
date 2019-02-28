<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use common\models\SCExpertsPairContacts;
use common\components\UtUploader;

/**
 * This is the model class for table "SC_orders".
 *
 * @property integer $orderID
 * @property integer $customerID
 * @property string $order_time
 * @property string $customer_ip
 * @property string $shipping_type
 * @property integer $shipping_module_id
 * @property string $payment_type
 * @property integer $payment_module_id
 * @property string $customers_comment
 * @property integer $statusID
 * @property double $shipping_cost
 * @property double $order_discount
 * @property string $discount_description
 * @property string $order_amount
 * @property string $currency_code
 * @property double $currency_value
 * @property string $customer_firstname
 * @property string $customer_lastname
 * @property string $customer_email
 * @property string $shipping_firstname
 * @property string $shipping_lastname
 * @property string $shipping_country
 * @property string $shipping_state
 * @property string $shipping_zip
 * @property string $shipping_city
 * @property string $shipping_address
 * @property string $billing_firstname
 * @property string $billing_lastname
 * @property string $billing_country
 * @property string $billing_state
 * @property string $billing_zip
 * @property string $billing_city
 * @property string $billing_address
 * @property string $cc_number
 * @property string $cc_holdername
 * @property string $cc_expires
 * @property string $cc_cvv
 * @property integer $affiliateID
 * @property string $shippingServiceInfo
 * @property string $google_order_number
 * @property string $source
 * @property string $id_1c
 * @property string $user_phone
 * @property string $source_ref
 * @property string $additional_info
 * @property integer $manager_id
 * @property integer $certificate_id
 * @property string $manager_1c_id
 * @property string $customer_patronname
 * @property int $payed
 * @property SCExperts $expert
 * @property SCExpertsPairContacts $expertsPairContacts
 * @property string $expertsPairMail
 * @property string $expertsPairMailerId
 * @property string $expertsPair
 *
 */
class SCOrders extends \yii\db\ActiveRecord
{
    const ORDER_SUCCESS = 'successOrder';

    public $containsItem;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_orders';
    }

    /**
     * @return object|\yii\db\Connection the database connection used by this AR class.
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
            [['customerID', 'shipping_module_id', 'payment_module_id', 'statusID', 'affiliateID', 'manager_id', 'certificate_id', 'payed'], 'integer'],
            [['order_time'], 'safe'],
            [['customers_comment', 'shipping_address', 'billing_address', 'source'], 'string'],
            [['shipping_cost', 'order_discount', 'order_amount', 'currency_value'], 'number'],
            [['discount_description'], 'required'],
            [['customer_ip'], 'string', 'max' => 150],
            [['shipping_type', 'payment_type'], 'string', 'max' => 255],
            [['discount_description', 'cc_number', 'cc_holdername', 'cc_expires', 'cc_cvv', 'shippingServiceInfo', 'source_ref'], 'string', 'max' => 255],
            [['currency_code'], 'string', 'max' => 7],
            [['customer_firstname', 'customer_lastname', 'shipping_firstname', 'shipping_lastname', 'shipping_country', 'shipping_state', 'shipping_zip', 'shipping_city', 'billing_firstname', 'billing_lastname', 'billing_country', 'billing_state', 'billing_zip', 'billing_city', 'customer_patronname'], 'string', 'max' => 64],
            [['customer_email', 'google_order_number'], 'string', 'max' => 50],
            [['id_1c', 'user_phone'], 'string', 'max' => 74],
            [['additional_info'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderID' => 'Номер заказа',
            'customerID' => 'Покупатель',
            'order_time' => 'Время заказа',
            'customer_ip' => 'IP покупателя',
            'shipping_type' => 'Доставка',
            'shipping_module_id' => 'Модуль доставки',
            'payment_type' => 'Оплата',
            'payment_module_id' => 'Модуль оплаты',
            'customers_comment' => 'Комментарий',
            'statusID' => 'Статус',
            'shipping_cost' => 'Стоимость доставки',
            'order_discount' => 'Скидка',
            'discount_description' => 'Описание скидки',
            'order_amount' => 'Сумма заказа',
            'currency_code' => 'Валюта',
            'currency_value' => 'Currency Value',
            'customer_firstname' => 'Customer Firstname',
            'customer_lastname' => 'Customer Lastname',
            'customer_email' => 'Customer Email',
            'shipping_firstname' => 'Shipping Firstname',
            'shipping_lastname' => 'Shipping Lastname',
            'shipping_country' => 'Shipping Country',
            'shipping_state' => 'Shipping State',
            'shipping_zip' => 'Shipping Zip',
            'shipping_city' => 'Shipping City',
            'shipping_address' => 'Shipping Address',
            'billing_firstname' => 'Billing Firstname',
            'billing_lastname' => 'Billing Lastname',
            'billing_country' => 'Billing Country',
            'billing_state' => 'Billing State',
            'billing_zip' => 'Billing Zip',
            'billing_city' => 'Billing City',
            'billing_address' => 'Billing Address',
            'cc_number' => 'Cc Number',
            'cc_holdername' => 'Cc Holdername',
            'cc_expires' => 'Cc Expires',
            'cc_cvv' => 'Cc Cvv',
            'affiliateID' => 'Affiliate ID',
            'shippingServiceInfo' => 'Shipping Service Info',
            'google_order_number' => 'Google Order Number',
            'source' => 'Source',
            'id_1c' => 'Id 1c',
            'user_phone' => 'User Phone',
            'manager_id' => 'Manager ID',

            'date' => 'Дата и время заказа',
            'customer' => 'Покупатель',
            'number' => 'Номер заказа',
            'status' => 'Статус',

            'containsItem' => 'Содержит товар (артикул)',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!$insert) {
            if ($this->statusID <> 1) {
                $bf = SCOrders::findOne($this->orderID);

                if (($bf->statusID <> $this->statusID) || $this->payed <> $bf->payed ) {
                    $mailerId = 'mailer_' . ($this->expertsPairMailerId ? $this->expertsPairMailerId : 'contacts');

                    $mailer = \Yii::$app->get($mailerId);

                    try {
                        $mail = $mailer->compose(
                            ['html' => '@frontend/views/mail/status_change'], ['order' => $this]
                        );
                        $mail->setTo([$this->customer_email]);
                        $mail->setSubject("Изменение статуса заказа №" . $this->orderID);

                        if ($mail->send()) {
                            /*\Yii::$app->bot->sendMessage(-14068578,
                                "Смена статуса Заказа #" . $this->orderID .
                                "\n\nПокупателю отправлено сообщение на почту:\n" . $this->customer_email .
                                "\n\nОтправитель - " . ($this->expertsPairMail ? $this->expertsPairMail : 'contacts@rybalkashop.ru')
                            );*/
                        } else {
                            \Yii::$app->bot->sendMessage(-14068578,
                                "Смена статуса Заказа #" . $this->orderID .
                                "\n\nПокупателю НЕ отправлено сообщение на почту:\n" . $this->customer_email .
                                "\n\nОтправитель - " . ($this->expertsPairMail ? $this->expertsPairMail : 'contacts@rybalkashop.ru')
                            );
                        }
                        //\Yii::$app->bot->sendMessage(-14068578, '!!! Смена статуса заказа №'.$this->orderID.' от '.$this->order_time.". C \"$oldname->status_name_ru\" на \"$newname->status_name_ru\"");
                    } catch (\Exception $e){
                        \Yii::$app->bot->sendMessage(-14068578,
                            "Смена статуса Заказа #". $this->orderID .
                            "\n\nОшибка:\n" . $e->getMessage() .
                            "\n\nВремя отправки - " . Yii::$app->formatter->asDatetime(time(),'php:H:i:s')
                        );
                    }
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            /*return \Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'notification',
                'message' => Json::encode(['message' => 'Новый заказ №'.$this->orderID])
            ]);*/
        }

        try{
            $model = new SCOrderStatusHistory();
            $model->orderID = $this->orderID;
            $model->statusID = $this->statusID;
            $model->time = time();

            $model->save();
            //\Yii::$app->bot->sendMessage(-14068578, "Попытка смены");
        } catch (\Exception $e){
            //\Yii::$app->bot->sendMessage(-14068578, $e->getTraceAsString());
        }
    }

    public function updateStatus()
    {
        if($this->statusID == 3) {
            $uploader = new UtUploader();
            $id = $uploader->getStatus($this);
            if (!empty($id) && $id <> 3) {
                $this->statusID = $id;
                $this->save(false);
            }
        }
    }

    public function getDate()
    {
        /*if (date('Y-m-d') == date('Y-m-d', strtotime($this->order_time))) {
            return 'Сегодня в '.date('H:i', strtotime($this->order_time));
        } elseif(date('Ymd', strtotime($this->order_time)) == date('Ymd', strtotime('yesterday'))){
            return 'Вчера в '.date('H:i', strtotime($this->order_time));
        } else {
            if(date('Y') > date('Y', strtotime($this->order_time))){
                return $this->replaceMonth(date('d F Y в H:i', strtotime($this->order_time)));
            } else {
                return $this->replaceMonth(date('d F в H:i', strtotime($this->order_time)));
            }
        }*/

        $timestamp = strtotime($this->order_time) + 60*60*3;

        return Yii::$app->formatter->asDatetime($timestamp, 'medium');
    }

    public function getNormalDate()
    {
        return date('d-m-Y', strtotime($this->order_time));
    }

    function replaceMonth($date)
    {
        $date = str_replace('January', 'Января', $date);
        $date = str_replace('February', 'Февраля', $date);
        $date = str_replace('March', 'Марта', $date);
        $date = str_replace('April', 'Апреля', $date);
        $date = str_replace('May', 'Мая', $date);
        $date = str_replace('June', 'Июня', $date);
        $date = str_replace('July', 'Июля', $date);
        $date = str_replace('August', 'Августа', $date);
        $date = str_replace('September', 'Сентября', $date);
        $date = str_replace('October', 'Октября', $date);
        $date = str_replace('November', 'Ноября', $date);
        $date = str_replace('December', 'Декабря', $date);

        return $date;
    }

    public function getCustomer()
    {
        $model = SCCustomers::find()->where("customerID = $this->customerID")->one();
        return $model->first_name.' '.$model->last_name.(!empty($this->customer_patronname)?' '.$this->customer_patronname:'');
    }

    public function getNumber()
    {
        $num = $this->orderID;
        $num_padded = sprintf("%08d", $num);
        return $num_padded;
    }

    public function getStatus()
    {
        $model = SCOrderStatus::find()->where("statusID = $this->statusID")->one();
        return $model->status_name_ru;
    }

    public function getVersionList()
    {
        $ar = array();
        $dates = SCOrderVersions::find()->where("orderID = $this->orderID")->groupBy("timestamp")->orderBy("timestamp DESC")->all();
        for($i = 0; $i < count($dates); $i++){
            $ts = $dates[$i]->timestamp;
            $ar[$i]['id'] = $i+1;
            $ar[$i]['data'] = SCOrderVersions::find()->where("orderID = $this->orderID")->andWhere("timestamp = '$ts'")->all();
        }
        return $ar;
    }

    public function getProducts()
    {
        return $this->hasMany(SCOrderedCarts::className(), ['orderID'=>'orderID']);
    }

    public function getContainsItem()
    {
        return 21;
    }

    public function getStatuses()
    {
        $models = SCOrderStatusHistory::find()->where(['orderID'=>$this->orderID]);
        $return = [];
        foreach ($models as $m){
            $return[$m->statusID] = $m->time;
        }
        return $return;
    }

    public function getStatusTitle()
    {
        if($this->statusID == 24){
            return $this->payed == 1?'<b>Оплачен</b> / Сборка заказа':'Сборка заказа';
        } elseif($this->statusID == 5){
            return $this->payed == 1?'<b>Оплачен</b> / отправлен':'Отправлен';
        } else {
            return SCOrderStatus::findOne($this->statusID)->status_name_ru;
        }
    }

    public function getMailTitle()
    {
        switch ($this->statusID){
            case 3:
                return 'поставлен в обработку!';
                break;
            case 24:
                return 'собирается на складе!';
                break;
            case 5:
                return 'отправлен покупателю!';
                break;
        }
        return SCOrderStatus::findOne($this->statusID)->status_name_ru;
    }

    public function getStatusModel() : SCOrderStatus
    {
        return SCOrderStatus::findOne($this->statusID);
    }

    public function getExpert() : SCExperts
    {
        return SCExperts::findOne($this->manager_id);
    }

    public function getExpertsPair() : SCExperts
    {
        if ($this->expert && !empty($this->expert->pair)) {
            return SCExperts::find()
                ->where([
                    'shop_id' => $this->expert->shop_id,
                    'pair'    => $this->expert->pair,
                ])
                ->all();
        }

        return null;
    }

    public function getExpertsPairContacts() : SCExpertsPairContacts
    {
        if ($this->expert && !empty($this->expert->pair)) {
            $model = SCExpertsPairContacts::findOne([
                'shop_id' => $this->expert->shop_id,
                'pair'    => $this->expert->pair,
            ]);

            return $model ? $model : null;
        }

        return null;
    }

    public function getExpertsPairMail() : string
    {
        $expertsPairContacts = $this->expertsPairContacts;

        return $expertsPairContacts ? $expertsPairContacts->email : null;
    }

    public function getExpertsPairMailerId() : string
    {
        $expertsPairContacts = $this->expertsPairContacts;

        return $expertsPairContacts ? $expertsPairContacts->mailer_id : null;
    }
}
