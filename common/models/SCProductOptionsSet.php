<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_options_set".
 *
 * @property integer $productID
 * @property integer $optionID
 * @property integer $variantID
 * @property double $price_surplus
 */
class SCProductOptionsSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_product_options_set';
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
            [['productID', 'optionID', 'variantID'], 'required'],
            [['productID', 'optionID', 'variantID'], 'integer'],
            [['price_surplus'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'optionID' => 'Option ID',
            'variantID' => 'Variant ID',
            'price_surplus' => 'Price Surplus',
        ];
    }
}
