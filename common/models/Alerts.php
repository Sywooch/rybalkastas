<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "alerts".
 *
 * @property integer $id
 * @property string $title
 * @property string $txt
 */
class Alerts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'txt'], 'required'],
            [['title', 'txt'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'txt' => 'Txt',
        ];
    }
}
