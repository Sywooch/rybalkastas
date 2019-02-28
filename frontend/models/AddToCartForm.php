<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AddToCartForm extends Model
{
    public $product;
    public $count;

    public function rules()
    {
        return [
            [['product', 'count'], 'required'],
            [['product'], 'integer'],
            ['count', 'compare', 'compareValue' => 1, 'operator' => '<', 'type' => 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'product' => 'Товар',
            'count' => 'Количество',
        ];
    }

    public function greaterThanOne($attribute,$params)
    {

        if ($this->$attribute < 1)
            $this->addError($attribute, 'Нельзя добавить меньше 1 позиции');

    }
}