<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_quiz".
 *
 * @property integer $id
 * @property string $name
 * @property integer $show
 * @property integer $active
 */
class SCQuiz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_quiz';
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
            [['name', 'show', 'active'], 'required'],
            [['show', 'active'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Предмет опроса',
            'show' => 'Show',
            'active' => 'Active',
        ];
    }
}
