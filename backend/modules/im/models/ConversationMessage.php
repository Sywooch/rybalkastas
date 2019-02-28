<?php

namespace backend\modules\im\models;

use Yii;
use yii\web\User;

/**
 * This is the model class for collection "conversation_message".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $sender
 * @property mixed $content
 * @property mixed $conversation_id
 * @property mixed $seen_by
 */
class ConversationMessage extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'conversation_message';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'sender',
            'content',
            'conversation_id',
            'seen_by',
            'timestamp',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'content', 'conversation_id', 'seen_by'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'sender' => 'Sender',
            'content' => 'Content',
            'conversation_id' => 'Conversation ID',
            'seen_by' => 'Seen By',
        ];
    }

    public function getUser()
    {
        return \common\models\User::findOne($this->sender);
    }

    public function getIsMe()
    {
        if($this->user->getPrimaryKey() == Yii::$app->user->getId()) return true;
        return false;
    }
}
