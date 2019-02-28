<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ReviewForm extends Model
{
    public $text;
    public $captcha;
    public $stars;

    public function rules()
    {
        return [
            [['text', 'captcha'], 'required'],
            [['captcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LdcehoUAAAAAHQ2tk1ENqxsjS2SYaLUBGkmfw_K', 'uncheckedMessage' => 'Пожалуйста, поставьте галочку!'],
            ['stars', 'number', 'min'=>0, 'max'=>5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Отзыв',
            'captcha' => 'Проверка',
            'stars' => 'Рейтинг'
        ];
    }
}