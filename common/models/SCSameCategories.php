<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_same_categories".
 *
 * @property integer $categoryID
 * @property integer $subcategoryID
 */
class SCSameCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_same_categories';
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
            [['categoryID', 'subcategoryID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'subcategoryID' => 'Subcategory ID',
        ];
    }

    public static function primaryKey(){
        return array('categoryID', 'subcategoryID');
    }
}
