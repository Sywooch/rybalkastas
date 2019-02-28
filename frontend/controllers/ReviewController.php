<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use common\models\SCShopRatings;
use common\services\RatingService;
use frontend\models\ReviewForm;

/**
 *
 * Class ReviewController
 * @package frontend\controllers
 *
 * @author Dmitriy Mosolov
 * @version 1.0
 *
 */
class ReviewController extends Controller
{
    public function actionIndex()
    {
        $query = SCShopRatings::find()
               ->where(['<>', 'hidden', 1])
            ->andWhere(['approved' => 1])
             ->orderBy(['created_at' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'models' => $models,
            'pages'  => $pages,
            'rating' => new ReviewForm(['stars' => 5]),
        ]);
    }

    public function actionSend()
    {
        RatingService::send(new ReviewForm(), Yii::$app->request->post());
    }

    public function actionValidation()
    {
        RatingService::formValidation(new ReviewForm(), Yii::$app->request->post());
    }
}
