<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_payment_types".
 *
 * @property integer $PID
 * @property integer $Enabled
 * @property integer $calculate_tax
 * @property integer $sort_order
 * @property integer $module_id
 * @property string $Name_en
 * @property string $description_en
 * @property string $email_comments_text_en
 * @property string $Name_ru
 * @property string $description_ru
 * @property string $email_comments_text_ru
 * @property string $logo
 */
class SCPaymentTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_payment_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Enabled', 'calculate_tax', 'sort_order', 'module_id'], 'integer'],
            [['email_comments_text_en', 'description_ru', 'email_comments_text_ru', 'logo'], 'string'],
            [['Name_en', 'Name_ru'], 'string', 'max' => 30],
            [['description_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PID' => 'Pid',
            'Enabled' => 'Enabled',
            'calculate_tax' => 'Calculate Tax',
            'sort_order' => 'Sort Order',
            'module_id' => 'Module ID',
            'Name_en' => 'Name En',
            'description_en' => 'Description En',
            'email_comments_text_en' => 'Email Comments Text En',
            'Name_ru' => 'Name Ru',
            'description_ru' => 'Description Ru',
            'email_comments_text_ru' => 'Email Comments Text Ru',
            'logo' => 'Logo',
        ];
    }
}
