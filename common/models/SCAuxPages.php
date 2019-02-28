<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_aux_pages".
 *
 * @property integer $aux_page_ID
 * @property integer $aux_page_text_type
 * @property string $aux_page_name_en
 * @property string $aux_page_text_en
 * @property string $aux_page_slug
 * @property string $meta_keywords_en
 * @property string $meta_description_en
 * @property integer $aux_page_enabled
 * @property integer $aux_page_priority
 * @property string $aux_page_name_ru
 * @property string $aux_page_text_ru
 * @property string $meta_keywords_ru
 * @property string $meta_description_ru
 * @property integer $aux_page_in_modal
 * @property integer $parent
 * @property integer $aux_page_in_footer
 */
class SCAuxPages extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 1;

    private static $STATUS_LIST = [
        self::STATUS_DELETED => 'Отключено',
        self::STATUS_ACTIVE  => 'Включено',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_aux_pages';
    }

    /**
     * @return \yii\db\Connection|Object
     * @throws \yii\base\InvalidConfigException
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
            [['aux_page_text_type', 'aux_page_enabled', 'aux_page_priority', 'aux_page_in_modal', 'parent', 'aux_page_in_footer'], 'integer'],
            [['aux_page_text_en', 'meta_description_en', 'aux_page_text_ru', 'meta_description_ru'], 'string'],
            [['aux_page_name_en', 'aux_page_slug', 'aux_page_name_ru'], 'string', 'max' => 64],
            [['meta_keywords_en', 'meta_keywords_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aux_page_ID' => 'ID',
            'aux_page_text_type' => 'Aux Page Text Type',
            'aux_page_name_en' => 'Aux Page Name En',
            'aux_page_text_en' => 'Aux Page Text En',
            'aux_page_slug' => 'Псевдоним',
            'meta_keywords_en' => 'Meta Keywords En',
            'meta_description_en' => 'Meta Description En',
            'aux_page_enabled' => 'Включена',
            'aux_page_priority' => 'Aux Page Priority',
            'aux_page_name_ru' => 'Название',
            'aux_page_text_ru' => 'Текст',
            'meta_keywords_ru' => 'Meta-keywords',
            'meta_description_ru' => 'Meta-description',
            'aux_page_in_modal' => 'Aux Page In Modal',
            'parent' => 'Parent',
            'aux_page_in_footer' => 'Aux Page In Footer',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusList() {
         return self::$STATUS_LIST;
    }
}
