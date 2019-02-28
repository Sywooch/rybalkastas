<?php

namespace frontend\components;

use Yii;
use yii\base\BootstrapInterface;
use app\models\Cms;  // assuming Cms is the Model class for table containing aliases
class DynaRoute implements BootstrapInterface
{
    public function bootstrap($app)
    {

        $cmsModel = Cms::find()
            ->all(); // customize the query according to your need
        $routeArray = [];
        foreach ($cmsModel as $row) { // looping through each cms table row
            $routeArray[$row->alias] = 'YOUR_ORIGINAL_URL'; // Adding rules to array on by one
        }
        $app->urlManager->addRules($routeArray);// Append new rules to original rules
    }
}