<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_secondary_slides".
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
 * @property integer $container
 */
class SCSecondarySlides extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_secondary_slides';
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
            [['image'], 'required'],
            [['container'], 'integer'],
            [['image'], 'string', 'max' => 555],
            [['text'], 'string', 'max' => 1500],
            [['title'], 'string', 'max' => 100],
            [['bgcolor'], 'string', 'max' => 7],
            [['offset_x', 'offset_y', 'txtcolor'], 'string', 'max' => 10],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Image',
            'text' => 'Text',
            'title' => 'Title',
            'bgcolor' => 'Bgcolor',
            'offset_x' => 'Offset X',
            'offset_y' => 'Offset Y',
            'txtcolor' => 'Txtcolor',
            'url' => 'Url',
            'id' => 'ID',
            'container' => 'Container',
        ];
    }
}
