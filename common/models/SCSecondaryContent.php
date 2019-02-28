<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_secondary_content".
 *
 * @property integer $id
 * @property string $url
 * @property integer $container
 * @property string $text
 * @property string $picture
 * @property integer $x
 * @property integer $y
 * @property integer $width
 * @property integer $height
 * @property string $txtcolor
 */
class SCSecondaryContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_secondary_content';
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
            [['container', 'text', 'picture'], 'required'],
            [['container', 'x', 'y', 'width', 'height'], 'integer'],
            [['url', 'text', 'picture', 'txtcolor'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'container' => 'Container',
            'text' => 'Text',
            'picture' => 'Picture',
            'x' => 'X',
            'y' => 'Y',
            'width' => 'Width',
            'height' => 'Height',
            'txtcolor' => 'Txtcolor',
        ];
    }
}
