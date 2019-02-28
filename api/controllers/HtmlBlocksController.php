<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 15.02.2019
 * Time: 9:29
 */

namespace api\controllers;


use yii\rest\Controller;

class HtmlBlocksController extends Controller
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
            ]
        ]);
    }

    public function actionIndex(){

    }
}