<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_specials_slider".
 *
 * @property integer $con_id
 * @property integer $product_id
 * @property integer $sort_order
 */
class SCSpecialsSlider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_specials_slider';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'sort_order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'con_id' => 'Con ID',
            'product_id' => 'Product ID',
            'sort_order' => 'Sort Order',
        ];
    }

    public function getProduct(){
        $model = SCProducts::findOne($this->product_id);
        return $model;
    }
}
