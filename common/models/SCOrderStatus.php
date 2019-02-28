<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_order_status".
 *
 * @property integer $statusID
 * @property integer $predefined
 * @property string $color
 * @property integer $bold
 * @property integer $italic
 * @property integer $sort_order
 * @property string $status_name_en
 * @property string $status_name_ru
 */
class SCOrderStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_order_status';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['predefined', 'bold', 'italic', 'sort_order'], 'integer'],
            [['color'], 'string', 'max' => 6],
            [['status_name_en', 'status_name_ru'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusID' => 'Status ID',
            'predefined' => 'Predefined',
            'color' => 'Color',
            'bold' => 'Bold',
            'italic' => 'Italic',
            'sort_order' => 'Sort Order',
            'status_name_en' => 'Status Name En',
            'status_name_ru' => 'Status Name Ru',
        ];
    }
}
