<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ErrorForm extends Model
{
    public $text;
    public $captcha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['text', 'captcha'], 'required'],
            [['captcha'], 'codeVerify'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Сообщение',
            'captcha' => 'Проверочный код',
        ];
    }

    public function codeVerify($attribute) {
        //Param:'captcha'，is name 'captcha' in actions() of controller；Yii::$app->controller，the controller that call this function
        $captcha_validate  = new \yii\captcha\CaptchaAction('captcha',Yii::$app->controller);
        if($this->$attribute){
            $code = $captcha_validate->getVerifyCode();
            if($this->$attribute!=$code){
                $this->addError($attribute, 'Код неверен!');
            }
        }
    }


}
