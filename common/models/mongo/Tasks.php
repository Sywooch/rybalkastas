<?php

namespace common\models\mongo;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for collection "tasks".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $user_id
 * @property mixed $created_by
 * @property mixed $updated_by
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $description
 * @property mixed $name
 * @property mixed $importance
 * @property mixed $objects
 * @property mixed $messages
 * @property mixed $done
 */
class Tasks extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['rybalkashop', 'tasks'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'user_id',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'description',
            'importance',
            'objects',
            'messages',
            'done',
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'description', 'importance', 'objects', 'messages', 'done', 'name'], 'safe']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'user_id' => 'Used ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'description' => 'Description',
            'importance' => 'Importance',
            'objects' => 'Objects',
            'messages' => 'Messages',
            'done' => 'Done',
        ];
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }

    public function getCreator()
    {
        return User::findOne($this->created_by);
    }

    public function getUpdator()
    {
        return User::findOne($this->updated_by);
    }
}
