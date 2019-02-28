<?php

namespace console\controllers;

/* @var $category SCCategories */

use common\models\SCProducts;
use yii\console\Controller;
use common\models\SCCategories;
use common\models\SCSameCategories;

/**
 * Class CleanController
 * @package console\controllers
 */
class CriticalController extends Controller
{
    public function actionCacheCanons(){
        $models = SCProducts::find()->select(['productID', 'categoryID'])->all();
        foreach($models as $m){
            if(empty($m->canon)) continue;
            echo $m->canon->productID.PHP_EOL;
        }
    }
}
