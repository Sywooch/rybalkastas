<?php

namespace frontend\components\validators;

use yii\validators\Validator;
use common\services\PhoneService;

/**
 *
 * Class PhoneValidator
 * @package frontend\components\validators
 *
 * @author Dmitriy Mosolov
 * @version 1.1 / last modified 28.11.2018
 *
 */
class PhoneValidator extends Validator
{
    public function init() {
        parent::init ();
    }

    /**
     * @param \frontend\models\OrderingForm $model
     * @param string $attribute
     */
    public function validateAttribute($model , $attribute) {
        $cleanedPhone = preg_replace('/[^0-9\+]/', '', $model->phone);
        $phoneCode    = PhoneService::getCodesValue()[$model->phonecode];

        if (!preg_match('/(^\\' . $phoneCode . ')/', $cleanedPhone)) {
            $this->addError($model, $attribute, "Номер должен начинаться с " . $phoneCode);
        }

        if (!PhoneService::isValidNumber($cleanedPhone, $model->phonecode)) {
            $this->addError($model, $attribute, "Номер указан некорректно");
        }
    }
}
