<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 07.02.2019
 * Time: 14:54
 */

namespace api\modules\backend\controllers;


use common\models\SCCategories;
use common\models\SCProducts;
use yii\helpers\Json;

class CatalogController extends  \api\components\Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionCategoryTree($id = 1){
        $cats = SCCategories::find()->where(['parent'=>$id])->orderBy(['sort_order'=>SORT_ASC])->all();
        $res = [];
        foreach($cats as $cat){
            $res[] = [
                'name_ru'=>$cat->name_ru,
                'categoryID'=>$cat->categoryID,
                'nodes'=>[],
                'isLeaf'=>false,
                'meta'=>Json::decode($cat->meta_data),
            ];
        }

        $current = SCCategories::findOne($id);
        $children = $current->getChilds();
        foreach($children as $cat){
            $res[] = [
                'name_ru'=>$cat->name_ru,
                'categoryID'=>$cat->categoryID,
                'nodes'=>[],
                'meta'=>Json::decode($cat->meta_data),
                'isLeaf'=>false,
                'isChild'=>true
            ];
        }

        $current_res = $current->toArray();
        $current_res['products'] = SCProducts::findAll(['categoryID'=>$current_res['categoryID']]);
        //$current_res['path']
        $products = SCProducts::findAll(['categoryID'=>$id]);

        return ['tree'=>$res, 'category'=>$current_res, 'products'=>$products];
    }

    public function actionTree(){

    }

    public function actionCategory($id){
        $category = SCCategories::findOne($id);
        return ['category'=>$category];
    }
}