<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_secondary_pages".
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property string $description
 * @property integer $brand
 * @property integer $show_new
 */
class SCSecondaryPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_secondary_pages';
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
            [['alias', 'name', 'brand'], 'required'],
            [['name', 'description'], 'string'],
            [['brand', 'show_new'], 'integer'],
            [['alias', 'head_image', 'link_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Псевдоним',
            'name' => 'Название',
            'description' => 'Описание',
            'brand' => 'Бренд',
            'show_new' => 'Show New',
            'head_image' => 'Шапка',
            'link_image' => 'Картинка бренда',
        ];
    }

    public function getContainers(){
        return SCSecondaryPagesContainers::find()->where("pageid = $this->id")->orderBy("order ASC")->all();
    }

    public function getBrandName()
    {
        return SCMonufacturers::findOne($this->brand)->name;
    }
}
