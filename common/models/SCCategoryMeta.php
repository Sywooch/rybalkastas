<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_category_meta".
 *
 * @property integer $categoryID
 * @property string $minPrice
 * @property string $maxPrice
 * @property integer $countChildren
 * @property integer $countAllChildren
 * @property integer $countProducts
 * @property integer $countInStock
 * @property integer $hasAction
 * @property integer $countActionInStock
 */
class SCCategoryMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_category_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoryID'], 'required'],
            [['categoryID', 'countChildren', 'countAllChildren', 'countProducts', 'countInStock', 'countActionInStock', 'hasAction'], 'integer'],
            [['minPrice', 'maxPrice'], 'number'],
            [['categoryID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'minPrice' => 'Min Price',
            'maxPrice' => 'Max Price',
            'countChildren' => 'Count Children',
            'countAllChildren' => 'Count All Children',
            'countProducts' => 'Count Products',
            'countInStock' => 'Count In Stock',
            'countActionInStock' => 'Count Action In Stock',
            'hasAction' => 'Has Action',
        ];
    }
}
