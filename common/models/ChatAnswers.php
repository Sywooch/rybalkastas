<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_answers".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $content
 */
class ChatAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'content'], 'required'],
            [['question_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'content' => 'Content',
        ];
    }
}
