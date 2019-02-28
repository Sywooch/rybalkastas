<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_followers".
 *
 * @property integer $id
 * @property integer $follower_id
 * @property integer $user_id
 */
class UserFollowers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_followers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follower_id', 'user_id'], 'required'],
            [['follower_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follower_id' => 'Follower ID',
            'user_id' => 'User ID',
        ];
    }

}
