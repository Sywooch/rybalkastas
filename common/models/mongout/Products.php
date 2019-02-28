<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "barcodes".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Products extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'products'];
    }

    /**
     * @return null|object|\yii\mongodb\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('mongout');
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'link',
            'parent',
            'id_1c',
            'name',
            'is_folder',
            'sku',
            'price',
            'old_price',
            'discount',
            'stock_provider',
            'stock_provider_obj',
            'stock',
            'reserved',
            'stock_full',
            'provider_full',
            'reserved_full',
            'partner_purchase'
        ];
    }

    public function fillable(){
        return [
            'parent',
            'id_1c',
            'name',
            'is_folder',
            'sku',
            'price',
            'discount'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['link', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
        ];
    }

    public function initialKeys()
    {
        return [
            'Ссылка'=>'link',
            'Родитель'=>'parent',
            'Код'=>'id_1c',
            'Наименование'=>'name',
            'ЭтоГруппа'=>'is_folder',
            'Артикул'=>'sku',
        ];
    }

    public function takeNeeded($ar)
    {
        $keys = $this->initialKeys();
        foreach($ar as $k=>$a){
            if(!in_array($k, array_keys($keys))) continue;
            $this->{$keys[$k]} = $a;
        }
    }
}
