<?php

namespace common\models;

use Yii;
use common\models\mongo\ProductAttributes;
use common\models\SCProducts;

/**
 * This is the model class for table "trash".
 *
 * @property integer $id
 * @property string $class
 * @property integer $item_id
 * @property string $created_at
 * @property string $created_by
 */
class Trash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trash';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class', 'item_id', 'created_at', 'created_by'], 'required'],
            [['item_id'], 'integer'],
            [['class', 'created_at', 'created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'lol',
            'class' => 'Class',
            'item_id' => 'Item ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public static function add($item)
    {
        $trash = new Trash;
        $trash->class = get_class($item);
        $trash->item_id = $item->getPrimaryKey();
        $trash->created_at = date('U');
        $trash->created_by = Yii::$app->user->getId();

        if(!$trash->save(false)){
            return false;
        }
    }

    public static function restore($item)
    {
        Trash::find()->where(['class'=>get_class($item)])->andWhere(['item_id'=>$item->getPrimaryKey()])->delete();
    }

    public function restoreInner()
    {
        Trash::deleteAll(['item_id'=>$this->item_id, 'class'=>$this->class]);
    }

    public function remove()
    {
        $className = $this->class;
        $object = $className::findOne($this->item_id);

        if ($className == SCProducts::class) {
            $mongoAttrs = ProductAttributes::find()
                ->where(['product_id' => (int)$this->item_id])
                  ->one();

            if ($mongoAttrs) {
                $mongoAttrs->delete();
            }
        }

        $object->delete();

        Trash::deleteAll([
            'item_id' => $this->item_id,
            'class' => $this->class
        ]);
    }

    public function getItemName(){

        $name = $this->class;

        switch ($this->class){
            case SCProducts::className():
                $name = SCProducts::findOne($this->item_id)->name_ru;
                break;
            case SCCategories::className():
                $name = SCCategories::findOne($this->item_id)->name_ru;
                break;
        }

        return $name;
    }

    public function getType()
    {
        $name = $this->class;

        switch ($this->class){
            case SCProducts::className():
                $name = "Товар";
                break;
            case SCCategories::className():
                $name = "Категория";
                break;
        }

        return $name;
    }

    public function getUser()
    {
        return User::findOne($this->created_by);
    }
}
