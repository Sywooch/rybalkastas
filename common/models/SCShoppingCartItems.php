<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_shopping_cart_items".
 *
 * @property integer $itemID
 * @property integer $productID
 */
class SCShoppingCartItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_shopping_cart_items';
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
            [['productID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemID' => 'Item ID',
            'productID' => 'Product ID',
        ];
    }


}
