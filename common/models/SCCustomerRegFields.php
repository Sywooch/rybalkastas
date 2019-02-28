<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_customer_reg_fields".
 *
 * @property integer $reg_field_ID
 * @property integer $reg_field_required
 * @property integer $sort_order
 * @property string $reg_field_name_en
 * @property string $reg_field_name_ru
 */
class SCCustomerRegFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_customer_reg_fields';
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
            [['reg_field_required', 'sort_order'], 'integer'],
            [['reg_field_name_en', 'reg_field_name_ru'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reg_field_ID' => 'Reg Field  ID',
            'reg_field_required' => 'Reg Field Required',
            'sort_order' => 'Sort Order',
            'reg_field_name_en' => 'Reg Field Name En',
            'reg_field_name_ru' => 'Reg Field Name Ru',
        ];
    }
}
