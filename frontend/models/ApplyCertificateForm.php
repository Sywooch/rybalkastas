<?php

namespace frontend\models;

use common\models\SCCertificates;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ApplyCertificateForm extends Model
{
    public $number;
    public $code;

    public function rules()
    {
        return [
            [['number', 'code'], 'required'],
            ['number', 'string', 'length'=>13],
            ['code', 'string'],
            [['code'], 'exist', 'targetClass'=>SCCertificates::className(), 'targetAttribute' => ['number'=>'certificateNumber', 'code'=>'certificateCode'],'filter'=>['certificateUsed'=>0], 'message'=>'Неверный номер карты или защитный код']
        ];
    }

    public function attributeLabels()
    {
        return [
            'number' => 'Номер карты',
            'code' => 'Защитный код',
        ];

    }

}