<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_order_versions".
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
 * @property string $timestamp
 * @property string $manager_id
 */
class SCOrderVersions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_order_versions';
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
            [['name', 'timestamp', 'manager_id'], 'string', 'max' => 255],
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
            'timestamp' => 'Timestamp',
            'manager_id' => 'Manager ID',
        ];
    }

    
}
