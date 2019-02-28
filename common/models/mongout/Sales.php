<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "barcodes".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Sales extends \yii\mongodb\ActiveRecord
{
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'sales'];
    }

    public static function getDb()
    {
        return Yii::$app->get('mongout');
    }

    public function attributes()
    {
        return [
            '_id',
            'document_id',
            'is_retail',
            'date',
            'items',
            'warehouse',
            'link',
        ];
    }
}