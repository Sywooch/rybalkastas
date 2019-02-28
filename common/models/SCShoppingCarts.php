<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_shopping_carts".
 *
 * @property integer $customerID
 * @property integer $itemID
 * @property integer $Quantity
 */
class SCShoppingCarts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_shopping_carts';
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
            [['customerID', 'itemID'], 'required'],
            [['customerID', 'itemID', 'Quantity'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customerID' => 'Customer ID',
            'itemID' => 'Item ID',
            'Quantity' => 'Quantity',
        ];
    }
}
