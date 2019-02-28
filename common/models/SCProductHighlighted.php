<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_highlighted".
 *
 * @property integer $product_id
 * @property string $highlight_color
 * @property integer $sort_order
 */
class SCProductHighlighted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_product_highlighted';
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
            [['highlight_color'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'highlight_color' => 'Highlight Color',
            'sort_order' => 'Sort Order',
        ];
    }

    public function getProduct(){
        $model = SCProducts::find()->where("productID = $this->product_id")->one();
        return $model;
    }
}
