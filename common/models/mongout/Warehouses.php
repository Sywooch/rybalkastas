<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "warehouses".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Warehouses extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'warehouses'];
    }

    /**
     * @return \yii\mongodb\Connection the MongoDB connection used by this AR class.
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

    public static function mainWarehouses(){
        return [
            ['name'=>'Птичка', 'link'=>'ab87a6e6-bc5f-11e2-bbf7-001e67042747'],
            ['name'=>'Братиславская', 'link'=>'e086e498-378e-11e2-a877-001e67042747'],
            ['name'=>'Дзержинский', 'link'=>'dc60d6ab-779f-4c41-a81d-f6ea8885dd41'],
            ['name'=>'Коньково', 'link'=>'8edc10b3-1612-11e8-a301-000c29c2a0da'],
            ['name'=>'Молодежная', 'link'=>'47b19ce7-54fd-11e7-92ed-001e67042746'],
            ['name'=>'Интернет', 'link'=>'4f57d723-eef4-11de-8cae-001c2507a956'],
        ];
    }
}
