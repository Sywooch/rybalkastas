<?php

namespace backend\modules\plant\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ThiefForm extends Model
{
    public $orderStatus;
    public $shippingMethod;
    public $positions;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['orderStatus', 'shippingMethod', 'positions'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'orderStatus' => 'Учитывая статус заказа',
            'shippingMethod' => 'Учитывая метод доставки',
            'positions' => 'Позиции (ID или SKU) через запятую',
        ];
    }

}
