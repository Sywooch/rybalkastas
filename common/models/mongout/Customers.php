<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "barcodes".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Customers extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'customers'];
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
            'is_folder',
            'id_1c',
            'name',
            'rating'
        ];
    }

    public function fillable(){
        return [
            'link',
            'parent',
            'is_folder',
            'id_1c',
            'name',
            'rating'
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
            'ЭтоГруппа'=>'is_folder',
            'Код'=>'id_1c',
            'Наименование'=>'name',
            'Рейтинг'=>'rating'
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
