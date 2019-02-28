<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ExpertQuestion extends Model
{
    public $message;
    public $post_id;

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['post_id'], 'integer'],
            [['message'], 'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение',
            'post_id' => 'ID',
        ];
    }


}