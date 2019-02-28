<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_product_options_categoryes".
 *
 * @property integer $categoryID
 * @property string $category_name_en
 * @property string $category_name_ru
 * @property integer $sort
 */
class SCProductOptionsCategoryes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */



    public static function tableName()
    {
        return 'SC_product_options_categoryes';
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
            [['category_name_en', 'category_name_ru'], 'required'],
            [['category_name_en', 'category_name_ru'], 'string'],
            [['sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'category_name_en' => 'Category Name En',
            'category_name_ru' => 'Category Name Ru',
            'sort' => 'Sort',
        ];
    }

    public function getOptions()
    {
        $model = SCProductOptions::find()->where("optionCategory = $this->categoryID")->orderBy("name_ru")->all();
        return $model;
    }

    public function getOptionnum()
    {
        $model = SCProductOptions::find()->where("optionCategory = $this->categoryID")->count();
        return $model;
    }

    public function getProductnum()
    {
        $model = SCProducts::find()->where("attr_cat = $this->categoryID")->count();
        return $model;
    }
}
