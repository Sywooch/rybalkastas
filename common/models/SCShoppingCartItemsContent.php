<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_shopping_cart_items_content".
 *
 * @property integer $itemID
 * @property integer $variantID
 */
class SCShoppingCartItemsContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_shopping_cart_items_content';
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
            [['itemID', 'variantID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemID' => 'Item ID',
            'variantID' => 'Variant ID',
        ];
    }
}
