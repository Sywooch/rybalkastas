<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "warehouses".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Statuses extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'statuses'];
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
            'name',
            'order',
            'class',
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
            'Название'=>'name',
            'Порядок'=>'order'
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
