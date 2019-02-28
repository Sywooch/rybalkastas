<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_cards".
 *
 * @property integer $id
 * @property integer $customerID
 * @property string $number
 * @property integer $discount_percent
 * @property string $discountPercent
 */
class SCCards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_cards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customerID', 'number', 'discount_percent'], 'required'],
            [['customerID', 'discount_percent'], 'integer'],
            [['number', 'discountPercent'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customerID' => 'Customer ID',
            'number' => 'Number',
            'discount_percent' => 'Discount Percent',
            'discountPercent' => 'Discount Percent',
        ];
    }
}
