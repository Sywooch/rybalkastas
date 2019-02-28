<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_customer_reg_fields_values".
 *
 * @property integer $reg_field_ID
 * @property integer $customerID
 * @property string $reg_field_value
 */
class SCCustomerRegFieldsValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_customer_reg_fields_values';
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
            [['reg_field_ID', 'customerID'], 'required'],
            [['reg_field_ID', 'customerID'], 'integer'],
            [['reg_field_value'], 'string', 'max' => 255],
            [['reg_field_ID', 'customerID'], 'unique', 'targetAttribute' => ['reg_field_ID', 'customerID'], 'message' => 'The combination of Reg Field  ID and Customer ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reg_field_ID' => 'Reg Field  ID',
            'customerID' => 'Customer ID',
            'reg_field_value' => 'Reg Field Value',
        ];
    }
}
