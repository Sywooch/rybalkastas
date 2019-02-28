<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_kits".
 *
 * @property integer $id
 * @property string $name
 * @property string $picture
 * @property string $description
 */
class SCKits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_kits';
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
            [['name', 'picture'], 'required'],
            [['description'], 'string'],
            [['name', 'picture'], 'string', 'max' => 255],
        ];
    }

    public function getElements(){
        return $this->hasOne(SCKitElements::className(), ['kit_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'picture' => 'Изображение',
            'description' => 'Описание',
        ];
    }
}
