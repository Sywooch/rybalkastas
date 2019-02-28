<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "SC_expert_messages".
 *
 * @property integer $id
 * @property integer $expert_id
 * @property integer $user_id
 * @property integer $old_user_id
 * @property string $message
 * @property integer $parent
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $edited_by
 */
class SCExpertMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_expert_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expert_id'], 'required'],
            [['expert_id', 'user_id', 'old_user_id', 'parent', 'created_by', 'edited_by'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expert_id' => 'Expert ID',
            'user_id' => 'User ID',
            'message' => 'Сообщение эксперту',
            'parent' => 'Parent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'edited_by' => 'Edited By',
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
                'updatedByAttribute' => 'edited_by',
            ],
        ];
    }

    public function getUserData()
    {
        $data = [];
        $emptyData = [
            'name' => SCExperts::findOne($this->expert_id)->expert_fullname,
            'avatar' => Yii::$app->params['emptyAvatar']
        ];
        if(empty($this->user_id) && empty($this->old_user_id)){
            return $emptyData;
        }

        if(empty($this->user_id)){
            $customer = SCCustomers::findOne($this->old_user_id);
            if(!empty($customer->user_id)){
                $this->user_id = $customer->user_id;
                $this->save();
            }

            if(empty($customer)){
                return $emptyData;
            }

            $data['name'] = $customer->first_name.' '.$customer->last_name;
            $data['avatar'] = Yii::$app->params['emptyAvatar'];
        } else {
            $user = User::findOne($this->user_id);
            $data['name'] = $user->profile->name;
            $data['avatar'] = $user->profile->thumbUrl; //TODO: ЗАМУТИТЬ АВАТАРКИ
        }

        return $data;
    }
}
