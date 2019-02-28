<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_related_categories".
 *
 * @property integer $categoryID
 * @property integer $relatedCategoryID
 */
class SCRelatedCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_related_categories';
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
            [['categoryID', 'relatedCategoryID'], 'required'],
            [['categoryID', 'relatedCategoryID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'relatedCategoryID' => 'Related Category ID',
        ];
    }
}
