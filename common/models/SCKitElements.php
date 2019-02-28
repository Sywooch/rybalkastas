<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_kit_elements".
 *
 * @property integer $id
 * @property integer $kit_id
 * @property integer $categoryID
 * @property integer $ratio
 */
class SCKitElements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_kit_elements';
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
            [['kit_id', 'categoryID'], 'required'],
            [['kit_id', 'categoryID', 'ratio'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kit_id' => 'Kit ID',
            'categoryID' => 'Category ID',
            'ratio' => 'Ratio',
        ];
    }

    public function getCategory()
    {
        $model = SCCategories::find()->where("categoryID = $this->categoryID")->one();
        return $model;
    }
}
