<?php

namespace common\models\mongout;

use Yii;

/**
 * This is the model class for collection "barcodes".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class AccessTokens extends \yii\mongodb\ActiveRecord
{
    public static function collectionName()
    {
        return ['rybalkashop_ut', 'access_tokens'];
    }

    public static function getDb()
    {
        return Yii::$app->get('mongout');
    }

    public function attributes()
    {
        return [
            '_id',
            'user_id',
            'token',
            'active_to'
        ];
    }
}