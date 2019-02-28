<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_specials".
 *
 * @property integer $con_id
 * @property integer $productID
 * @property integer $sort_order
 */
class SCSpecials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_specials';
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
            [['productID', 'sort_order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'con_id' => 'Con ID',
            'productID' => 'Product ID',
            'sort_order' => 'Sort Order',
        ];
    }

    public function getProduct(){
        if(empty($this->productID))return false;
        $model = SCProducts::find()->where("productID = $this->productID")->one();
        if(!empty($model)){
            return $model;
        }
        return false;
    }
}
