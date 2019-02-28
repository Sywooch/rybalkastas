<?php

namespace common\models\mongo;

use Yii;

/**
 * This is the model class for collection "ipsByDate".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $date
 * @property mixed $ips
 */
class IpsByDate extends \yii2tech\embedded\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'ipsByDate';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'date',
            'ips',
        ];
    }

    /**
     * @inheritdoc
     */


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'date' => 'Date',
            'ips' => 'Ips',
        ];
    }

    public function embedIpsModel()
    {
        return $this->mapEmbedded('ips', Ip::className());
    }
}
