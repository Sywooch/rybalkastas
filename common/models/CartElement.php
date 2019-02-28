<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart_element".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $model
 * @property integer $cart_id
 * @property integer $item_id
 * @property integer $count
 * @property string $price
 * @property string $hash
 * @property string $options
 *
 * @property Cart $cart
 */
class CartElement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_element';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'cart_id', 'item_id', 'count'], 'integer'],
            [['model', 'cart_id', 'item_id', 'count', 'hash'], 'required'],
            [['price'], 'number'],
            [['options'], 'string'],
            [['model'], 'string', 'max' => 110],
            [['hash'], 'string', 'max' => 255],
            //[['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'model' => 'Model',
            'cart_id' => 'Cart ID',
            'item_id' => 'Item ID',
            'count' => 'Count',
            'price' => 'Price',
            'hash' => 'Hash',
            'options' => 'Options',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }*/
}
