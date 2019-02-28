<?php

namespace backend\modules\im\models;

use common\models\User;
use Yii;

/**
 * This is the model class for collection "conversation".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $users
 * @property mixed $last
 */
class Conversation extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'conversation';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'users',
            'last',
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users', 'last'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'users' => 'Users',
            'last' => 'Last',
        ];
    }

    public function getIsConv()
    {
        if(count($this->users) == 2){
            return false;
        }

        return true;
    }

    public function getUser()
    {
        $users = $this->users;
        $p = array_diff($users, [Yii::$app->user->getId()]);
        $id = array_shift($p);
        $model = User::findOne($id);
        return $model;
    }

    public function getTitle()
    {
        if($this->isConv){
            return $this->name;
        } else {
            return $this->user->profile->name;
        }
    }
}
