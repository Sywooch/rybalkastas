<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 03.04.2017
 * Time: 9:49
 */

namespace backend\models;
use yii\base\Model;



class MailerForm extends Model
{
    public $content;
    public $from;
    public $test;
    public $subject;

    public function rules()
    {
        $rules = [];
        $rules[] = [['from'], 'email'];
        $rules[] = [['content', 'subject'], 'string'];
        $rules[] = [['test'], 'boolean'];
        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'from' => 'Отправитель',
            'subject' => 'Тема письма',
            'content' => 'Контент',
            'test' => 'Запустить тестово',
        ];
    }
}