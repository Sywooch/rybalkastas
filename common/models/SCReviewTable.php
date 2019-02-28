<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "SC_review_table".
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $description_ru
 * @property string $description_en
 * @property string $products
 * @property int $sort_order
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class SCReviewTable extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static $statusList = [
        self::STATUS_ACTIVE  => 'Включено',
        self::STATUS_DELETED => 'Отключено',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SC_review_table';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        $this->created_at = Yii::$app->formatter->asDate($this->created_at,'php:d.m.y H:i');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_ru', 'description_ru'], 'required'],
            [['sort_order', 'status'], 'integer'],
            [['description_ru', 'description_en', 'products'], 'string'],
            [['title_ru', 'title_en'], 'string', 'max' => 255],

            ['sort_order', 'default' , 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title_ru' => 'Наименование',
            'description_ru' => 'Описание',
            'products' => 'Добавить к продуктам',
            'sort_order' => 'Порядок сортировки',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }
}
