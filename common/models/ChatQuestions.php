<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_questions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $operator_id
 * @property string $content
 * @property string $date
 * @property integer $seen_by_operator
 */
class ChatQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'operator_id', 'content', 'date'], 'required'],
            [['user_id', 'operator_id', 'seen_by_operator'], 'integer'],
            [['content'], 'string'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'operator_id' => 'Operator ID',
            'content' => 'Content',
            'date' => 'Date',
            'seen_by_operator' => 'Seen By Operator',
        ];
    }
}
