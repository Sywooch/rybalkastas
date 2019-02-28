<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_cities".
 *
 * @property integer $cityID
 * @property string $cityName
 * @property integer $sdek_ShipPrice_home
 * @property integer $sdek_ShipPrice_pickup
 */
class SCCities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdek_ShipPrice_home', 'sdek_ShipPrice_pickup'], 'integer'],
            [['cityName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cityID' => 'City ID',
            'cityName' => 'City Name',
            'sdek_ShipPrice_home' => 'Sdek  Ship Price Home',
            'sdek_ShipPrice_pickup' => 'Sdek  Ship Price Pickup',
        ];
    }
}
