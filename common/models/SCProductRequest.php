<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_request".
 *
 * @property integer $productID
 * @property integer $customerID
 */
class SCProductRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_product_request';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
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
            [['productID', 'customerID'], 'required'],
            [['productID', 'customerID', '1_wave_sent'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'customerID' => 'Customer ID',
        ];
    }

    public function getCount(){
        return $this->find()->where("productID = $this->productID")->count();
    }

    public function getProduct(){
        return SCProducts::find()->where("productID = $this->productID")->one();
    }

    public function getCustomer(){
        return SCCustomers::find()->where("customerID = $this->customerID")->one();
    }
}
