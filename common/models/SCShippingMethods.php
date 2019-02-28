<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_shipping_methods".
 *
 * @property integer $SID
 * @property integer $Enabled
 * @property integer $module_id
 * @property integer $sort_order
 * @property string $Name_en
 * @property string $description_en
 * @property string $email_comments_text_en
 * @property string $Name_ru
 * @property string $description_ru
 * @property string $email_comments_text_ru
 * @property string $logo
 * @property int $shop_id
 */
class SCShippingMethods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_shipping_methods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Enabled', 'module_id', 'sort_order'], 'integer'],
            [['email_comments_text_en', 'email_comments_text_ru', 'logo'], 'string'],
            [['Name_en', 'Name_ru'], 'string', 'max' => 30],
            [['description_en', 'description_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SID' => 'Sid',
            'Enabled' => 'Enabled',
            'module_id' => 'Module ID',
            'sort_order' => 'Sort Order',
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
