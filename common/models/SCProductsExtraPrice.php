<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_products_extra_price".
 *
 * @property int $productID
 * @property double $Price
 * @property double $list_price
 * @property int $maxDiscount
 * @property string $key
 */
class SCProductsExtraPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SC_products_extra_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productID', 'Price', 'key'], 'required'],
            [['productID', 'maxDiscount'], 'integer'],
            [['Price', 'list_price'], 'number'],
            [['key'], 'string', 'max' => 16],
            [['productID', 'key'], 'unique', 'targetAttribute' => ['productID', 'key']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productID' => 'Product ID',
            'Price' => 'Price',
            'list_price' => 'List Price',
            'maxDiscount' => 'Max Discount',
            'key' => 'Key',
        ];
    }

    public static function keysOfInterest()
    {
        return [
            'bf_1' => 'bf1',
            'bf_2' => 'bf2',
            'bf_3' => 'bf3',
            'bf_1_over' => 'bf_big',
        ];
    }

    /**
     * @param array $data[
     *  'productID' => (int) ID товара
     *  'key' => (string) ключ из keysOfInterest()
     *  'list_price' => (int) Старая цена
     *  'Price' => (int) Цена
     *  'maxDiscount' => (int) % скидки
     * ]
     * @return int
     */
    public static function insertPrice(array $data)
    {
        $model = self::findOne([
            'productID' => $data['productID'],
            'key'       => $data['key']
        ]);

        if (empty($model)) {
            $model = new self;
        }

        $model->attributes = $data;

        $model->save();
    }
}
