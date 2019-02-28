<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use karpoff\icrop\CropImageUploadBehavior;
use phpDocumentor\Reflection\Types\Object_;

/**
 * This is the model class for table "SC_slider1".
 *
 * @property string $image
 * @property string $text
 * @property string $title
 * @property string $bgcolor
 * @property string $offset_x
 * @property string $offset_y
 * @property string $txtcolor
 * @property string $url
 * @property integer $id
 * @property integer $disabled
 * @property string $sort_order
 * @property bool $deleted_at
 */
class SCSlider1 extends \yii\db\ActiveRecord
{
    private static $DELETED_STATUS  = 1;
    private static $DISABLED_STATUS = 1;

    public static function getDeletedStatusValue() {
        return self::$DELETED_STATUS;
    }

    public static function getDisabledStatusValue() {
        return self::$DISABLED_STATUS;
    }

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'SC_slider1';
    }

    /**
     * @return \yii\db\Connection|Object the database connection used by this AR class.
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
            [['image'], 'required'],
            ['image', 'file', 'extensions' => 'jpeg, gif, png, jpg', 'on' => ['insert', 'update']],
            [['text'], 'string', 'max' => 1500],
            [['title'], 'string', 'max' => 100],
            [['bgcolor'], 'string', 'max' => 7],
            [['sort_order', 'disabled'], 'integer'],
            [['offset_x', 'offset_y', 'txtcolor'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => Yii::getAlias('@frontend/web/img/slider'),
                'url' => 'http://rybalkashop.ru/img/slider',
                'ratio' => 19/4,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Изображение',
            'text' => 'Текст',
            'title' => 'Title',
            'bgcolor' => 'Цвет фона',
            'offset_x' => 'Offset X',
            'offset_y' => 'Offset Y',
            'txtcolor' => 'Цвет текста',
            'url' => 'Ссылка',
            'id' => 'ID',
            'disabled' => 'Отключен',
        ];
    }
}
