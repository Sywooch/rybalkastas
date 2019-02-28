<?php

namespace common\models;

use dektrium\user\models\User as DUser;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_activity".
 *
 * @property integer $actionID
 * @property integer $user_id
 * @property string $actionObject
 * @property integer $object_id
 * @property integer $object_name
 * @property string $actionType
 * @property string $dataBefore
 * @property string $dataAfter
 * @property string $customContent
 * @property string $date
 * @property string $linktousers
 */
class UserActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'actionObject'], 'required'],
            [['user_id', 'object_id'], 'integer'],
            [['dataBefore', 'dataAfter', 'customContent', 'object_name'], 'string'],
            [['date'], 'safe'],
            [['actionObject', 'actionType'], 'string', 'max' => 255],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionID' => 'Action ID',
            'user_id' => 'User ID',
            'actionObject' => 'Action Object',
            'object_id' => 'Object ID',
            'actionType' => 'Action Type',
            'dataBefore' => 'Data Before',
            'dataAfter' => 'Data After',
            'customContent' => 'Custom Content',
            'date' => 'Date',
            'linktousers' => 'Linktousers',
        ];
    }

    public function getUser(){
        $model = DUser::find()->where("id = $this->user_id")->one();
        return $model;
    }

    public function getContent(){
        switch($this->actionObject){
            case "Category":
                return $this->renderCategory();
            case "Product":
                return $this->renderProduct();
        }

        return null;
    }

    public function putActivity($object, $object_id, $type, $object_name = false){
        $act = new UserActivity;
        $act->user_id = Yii::$app->user->identity->id;
        $act->actionObject = $object;
        $act->object_id = $object_id;
        if($object_name){
            $act->object_name = $object_name;
        }
        $act->actionType = $type;

        //$act->date = date('Y-m-d h:i:s');
        $act->save();
    }

    public function putCustom($content){
        $act = new UserActivity;
        $act->user_id = Yii::$app->user->identity->id;
        $act->actionObject = 'Custom';
        $act->customContent = $content;
        $act->save();
    }

    public function renderCategory(){
        $cat = SCCategories::find()->where("categoryID = $this->object_id")->one();
        if(!empty($cat)) {
            if (!empty($cat->picture)) {
                $img = '<img style="float:left;width: 43px;margin-right: 10px;" class="img-circle img-bordered-sm" src="/published/publicdata/TESTRYBA/attachments/SC/products_pictures/' . $cat->picture . '">';
            } else {
                $img = '';
            }
            return $img . "<div>Обновил категорию <br><b>$cat->name_ru</b></div>";
        }
    }

    public function renderProduct(){
        $prd = SCProducts::find()->where("productID =  $this->object_id")->one();
        if(!empty($prd)){
            $name = $prd->name_ru;
        } else {
            $name = "Товар удален из базы.";
        }
        if(!empty($prd->picurl)){
            $img = '<img style="float:left;width: 43px;margin-right: 10px;" class="img-circle img-bordered-sm" src="/published/publicdata/TESTRYBA/attachments/SC/products_pictures/'.$prd->picurl.'">';
        } else {
            $img = '';
        }
        return $img."<div>Обновил продукт <br><b>$name</b></div>";
    }

    public static function todayActivityCount()
    {
        $year = date("Y");
        $month = date("m");
        $day = date ("d");


        $count = UserActivity::find()->where("date BETWEEN '$year-$month-$day 00:00:00' AND '$year-$month-$day 23:59:59'")->count();
        return $count;
    }


}
