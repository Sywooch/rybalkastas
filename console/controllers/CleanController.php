<?php

namespace console\controllers;

/* @var $category SCCategories */

use yii\console\Controller;
use common\models\SCCategories;
use common\models\SCSameCategories;

/**
 * Class CleanController
 * @package console\controllers
 */
class CleanController extends Controller
{
    public function actionCleanSameProducts()
    {
        $categories = SCCategories::find()->all();

        foreach ($categories as $category) {
            if (!$category->hasProducts) {
                SCSameCategories::deleteAll(['categoryID' => $category->categoryID]);

                echo $category->name_ru . ' очищена!' . PHP_EOL;
            }
        }
    }
}
