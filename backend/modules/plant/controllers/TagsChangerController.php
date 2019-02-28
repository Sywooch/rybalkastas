<?php

namespace backend\modules\plant\controllers;

use common\models\SCProductOptionsCategoryes;
use common\models\SCProductOptionsValues;
use common\models\SCProducts;
use yii\web\Controller;
use common\models\SCCategories;
use common\models\UserActivity;
use common\models\UserNotifications;
use yii\web\Session;

class TagsChangerController extends Controller
{
    public function actionIndex(){
        $category_id = 3345;
        $cats = SCCategories::catGetSubCategories($category_id);
        $ar = array();
        $ar[] = $category_id;
        foreach($cats as $c){
            $ar[] = $c->categoryID;
        }


        $mons = ['Shimano','Shimano Nexus', 'Shimano/Nexus'];

        $categories = SCCategories::find()->where(['in', 'categoryID', $ar])->andWhere(['in','monufacturer',$mons])->all();

        foreach ($categories as $category){
            $category->monufacturer = "Shimano/Nexus";
            $category->save();
        }
    }
}