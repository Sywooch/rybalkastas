<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 03.04.2017
 * Time: 9:49
 */

namespace frontend\models;
use yii\base\Model;



class CustomerForm extends Model
{
    /**
     * Add a new field
     * @var string
     */
    public $first_name;
    public $last_name;
    public $phone;
    public $city;
    public $street;
    public $house;
    public $zip;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        $rules[] = [['first_name', 'last_name','phone', 'city','street','house','zip'], 'required'];
        $rules[] = [['first_name', 'last_name','phone', 'street','house','zip'], 'string', 'max' => 255];
        $rules[] = ['city', 'exist', 'targetClass'=>'common\models\SCCities', 'targetAttribute'=>'cityID'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [];
        $labels['first_name'] = \Yii::t('user', 'Имя');
        $labels['last_name'] = \Yii::t('user', 'Фамилия');
        $labels['phone'] = \Yii::t('user', 'Номер телефона');
        $labels['city'] = \Yii::t('user', 'Город');
        $labels['street'] = \Yii::t('user', 'Улица');
        $labels['house'] = \Yii::t('user', 'Дом');
        $labels['zip'] = \Yii::t('user', 'Почтовый индекс');
        return $labels;
    }

}