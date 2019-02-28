<?php

namespace common\models\mongout;

use MongoDB\BSON\UTCDateTime;
use Yii;

/**
 * This is the model class for collection "barcodes".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Orders extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'orders'];
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
            'confirmed',
            'created_at',
            'payment_date',
            'shipping_date',
            'discount_card_link',
            'comment',
            'customer_link',
            'user_link',
            'unit_link',
            'warehouse_link',
            'site_id',
            'payment_type',
            'shipping_type',
            'warehouse_cell_link',
            'is_collected',
            'is_regional',
            'is_combined',
            'combined_to',
            'is_payed',
            'source',
            'products',
            'services',
            'certificates',
            'status',
            'closed_at'
        ];
    }

    public function fillable(){
        return [
            'link',
            'parent',
            'id_1c',
            'confirmed',
            'created_at',
            'payment_date',
            'shipping_date',
            'discount_card_link',
            'comment',
            'customer_link',
            'user_link',
            'unit_link',
            'warehouse_link',
            'site_id',
            'payment_type',
            'shipping_type',
            'warehouse_cell_link',
            'is_collected',
            'is_regional',
            'is_combined',
            //'combined_to',
            'is_payed',
            'source',
            'products',
            'services',
            'certificates',
            'status',
            'closed_at'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['link', 'unique'],
            ['user_link', 'string'],
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
            'Номер'=>'id_1c',
            'Проведен'=>'confirmed',
            'Дата'=>'created_at',
            'ДатаОплаты'=>'payment_date',
            'ДатаОтгрузки'=>'shipping_date',
            'ДисконтнаяКартаСсылка'=>'discount_card_link',
            'Комментарий'=>'comment',
            'КонтрагентСсылка'=>'customer_link',
            'ОтветственныйСсылка'=>'user_link',
            'ПодразделениеСсылка'=>'unit_link',
            'СкладГруппа'=>'warehouse_link',
            'НомерВходящегоДокументаЭлектронногоОбмена'=>'site_id',
            'ВидОплаты'=>'payment_type',
            'ВидДоставки'=>'shipping_type',
            'ЯчейкаХранения.Ссылка'=>'warehouse_cell_link',
            'ЗаказСобран'=>'is_collected',
            'РегиональныйЗаказ'=>'is_regional',
            'Объединен'=>'is_combined',
            //''=>'combined_to',
            'Оплачен'=>'is_payed',
            'Источник'=>'source',
            'Товары'=>'products',
            'Услуги'=>'services',
            'Сертификаты'=>'certificates',
            'СтатусЗаказа'=>'status',
        ];
    }

    public function takeNeeded($ar)
    {
        $keys = $this->initialKeys();
        foreach($ar as $k=>$a){
            if(!in_array($k, array_keys($keys))) continue;
            if(is_array($a)){
                if($k == 'Товары'){
                    $products = [];
                    foreach($a as $prd){
                        $product = [];
                        $product['link'] = $prd['Номенклатура'];
                        //$product['name'] = $prd['Наименование'];
                        $product['quantity'] = $prd['Количество'];
                        $product['allocation'] = $prd['Размещение'];
                        $product['price'] = $prd['Цена'];
                        $product['sum'] = $prd['Цена'];
                        $products[] = $product;
                    }
                    $this->{$keys[$k]} = $products;
                }

                if($k == 'Услуги'){
                    $services = [];
                    foreach($a as $prd){
                        $product = [];
                        $product['link'] = $prd['Номенклатура'];
                        $product['name'] = @$prd['Наименование'];
                        $product['quantity'] = $prd['Количество'];
                        $product['allocation'] = @$prd['Размещение'];
                        $product['price'] = $prd['Цена'];
                        $product['sum'] = $prd['Сумма'];
                        $services[] = $product;
                    }
                    $this->{$keys[$k]} = $services;
                }

                if($k == 'Сертификаты'){
                    $certificates = [];
                    foreach($a as $prd){
                        $product = [];
                        $product['link'] = $prd['Номенклатура'];
                        $product['char_link'] = $prd['ХарактеристикаНоменклатуры'];
                        $product['sum'] = $prd['Сумма'];
                        $product['sum_used'] = $prd['СуммаИспользования'];
                        $certificates[] = $product;
                    }
                    $this->{$keys[$k]} = $certificates;
                }
            } else {
                $this->{$keys[$k]} = $a;
            }
        }
    }

    public function getUser(){
        return $this->hasOne(Users::className(), ['link'=> 'user_link']);
    }

    public function getCustomer(){
        return $this->hasOne(Customers::className(), ['link'=> 'customer_link']);
    }

    public function getStatus(){
        return $this->hasOne(Statuses::className(), ['link'=> 'status']);
    }

    public function beforeSave($insert)
    {
        $dates = ['created_at','payment_date','shipping_date','closed_at'];
        foreach($dates as $f){
            if(!empty($this->{$f}))
                $this->{$f} = new UTCDateTime((new \DateTime($this->{$f}))->getTimestamp().'000');
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
