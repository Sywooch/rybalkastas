<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_parental_connections".
 *
 * @property integer $categoryID
 * @property integer $parent
 */
class SCParentalConnections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_parental_connections';
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
            [['categoryID', 'parent'], 'required'],
            [['categoryID', 'parent'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryID' => 'Category ID',
            'parent' => 'Parent',
        ];
    }

    public static function primaryKey(){
        return array('categoryID', 'parent');
    }
}
