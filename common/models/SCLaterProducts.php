<?php

namespace common\models;

use Yii;
use common\models\SCProducts;

/**
 * This is the model class for table "SC_later_products".
 *
 * @property integer $userID
 * @property integer $productID
 */
class SCLaterProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_later_products';
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
            [['userID', 'productID'], 'required'],
            [['userID', 'productID'], 'integer'],
        ];
    }

    public function getProduct()
    {
        return SCProducts::findOne($this->productID);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userID' => 'User ID',
            'productID' => 'Product ID',
        ];
    }
}
