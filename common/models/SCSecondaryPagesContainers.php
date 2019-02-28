<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SC_secondary_pages_containers".
 *
 * @property integer $id
 * @property integer $pageid
 * @property string $name
 * @property string $content
 * @property integer $order
 */
class SCSecondaryPagesContainers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SC_secondary_pages_containers';
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
            [['pageid', 'order'], 'integer'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 70],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pageid' => 'Pageid',
            'name' => 'Название',
            'content' => 'Content',
            'order' => 'Order',
        ];
    }

    public function getLinks(){
        return SCSecondaryPagesLinks::find()->where("page_id = $this->id")->orderBy("sort_order ASC")->all();
    }
}
