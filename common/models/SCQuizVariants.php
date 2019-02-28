<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_quiz_variants".
 *
 * @property integer $id
 * @property integer $quiz_id
 * @property string $name
 * @property integer $sort_order
 */
class SCQuizVariants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_quiz_variants';
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
            [['name', 'quiz_id'], 'required'],
            [['sort_order', 'quiz_id'], 'integer'],
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
            'quiz_id' => 'Quiz ID',
            'name' => 'Name',
            'sort_order' => 'Sort Order',
        ];
    }
}
