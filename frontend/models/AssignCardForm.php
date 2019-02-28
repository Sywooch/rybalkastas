<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AssignCardForm extends Model
{
    public $card;
    public $user_id;

    public function rules()
    {
        return [
            [['card'], 'string', 'max' => 13, 'min'=>13],
            [['user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'card' => 'Номер карты',
        ];
    }

    public function greaterThanOne($attribute,$params)
    {

        if ($this->$attribute < 1)
            $this->addError($attribute, 'Нельзя добавить меньше 1 позиции');

    }
}