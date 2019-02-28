<?php

namespace common\models;

use dektrium\user\models\User as DUser;
use Yii;

/**
 * This is the model class for table "user_notifications".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $from_user_id
 * @property string $content
 * @property integer $shown
 * @property integer $seen
 */
class UserNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content'], 'required'],
            [['user_id', 'from_user_id', 'shown', 'seen'], 'integer'],
            [['content','type'], 'string'],
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
            'from_user_id' => 'From User ID',
            'content' => 'Content',
            'shown' => 'Shown',
            'seen' => 'Seen',
        ];
    }

    public function putMassNotify($user_id, $content)
    {
        $followers = UserFollowers::find()->where("user_id = $user_id")->all();
        foreach($followers as $f){
            $this->putNotify($f->follower_id, $content, $user_id);
        }
    }

    public function putNotify($user_id, $content, $from_user_id = null){
        $act = new UserNotifications;
        $act->user_id = $user_id;
        $act->content = $content;
        $act->from_user_id = $from_user_id;
        $act->shown = 0;
        $act->seen = 0;
        $act->date = date('Y-m-d h:i:s');
        $act->save();
    }

    public function getUser(){
        if(!empty($this->from_user_id)){
            $model = DUser::find()->where("id = $this->from_user_id")->one();
            return $model;
        } else {
            return false;
        }

    }
}
