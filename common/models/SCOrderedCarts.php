<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_ordered_carts".
 *
 * @property integer $itemID
 * @property integer $orderID
 * @property string $name
 * @property double $Price
 * @property integer $Quantity
 * @property double $tax
 * @property integer $load_counter
 * @property integer $1c_id
 * @property double $DefaultPrice
 * @property integer $Discount
 */
class SCOrderedCarts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_ordered_carts';
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
            [['itemID', 'orderID'], 'required'],
            [['itemID', 'orderID', 'Quantity', 'load_counter', '1c_id', 'Discount'], 'integer'],
            [['Price', 'tax', 'DefaultPrice'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemID' => 'Item ID',
            'orderID' => 'Order ID',
            'name' => 'Name',
            'Price' => 'Price',
            'Quantity' => 'Quantity',
            'tax' => 'Tax',
            'load_counter' => 'Load Counter',
            '1c_id' => '1c ID',
            'DefaultPrice' => 'Default Price',
            'Discount' => 'Discount',
        ];
    }

    public function getProduct()
    {
        $str = $this->name;
        preg_match('/\[(.*?)\]/', $str, $matches);
        $model = SCProducts::find()->where(['product_code'=>$matches[1]])->one();
        return $model;
    }
}
