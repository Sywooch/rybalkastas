<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_payment_types__shipping_methods".
 *
 * @property integer $SID
 * @property integer $PID
 */
class SCPaymentTypesShippingMethods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_payment_types__shipping_methods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SID', 'PID'], 'required'],
            [['SID', 'PID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SID' => 'Sid',
            'PID' => 'Pid',
        ];
    }
}
