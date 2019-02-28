<?php

namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use common\models\SCShopRatings;
use common\models\SCRatings;
use common\services\RatingService;

class RatingsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'hide'      => ['POST'],
                    'confirmed' => ['POST'],
                ]
            ]
        ];
    }

    public function actionIndex($showhidden = 0)
    {
        $query = SCShopRatings::find();

        if ($showhidden == 0) {
            $query->where('hidden = 0');
        }

        $query->orderBy(['created_at' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'model'      => $model,
            'pages'      => $pages,
            'showhidden' => $showhidden
        ]);
    }

    public function actionReply()
    {
        RatingService::reply(
            $_POST['SCShopRatings']['rating_id'],
            $_POST['SCShopRatings']['response_text']
        );
    }

    public function actionHide()
    {
        RatingService::ratingHide(
            $_POST['SCShopRatings']['rating_id'],
            $_POST['SCShopRatings']['hidden']
        );
    }

    public function actionConfirmed()
    {
        RatingService::ratingConfirmed(
            $_POST['SCShopRatings']['rating_id'],
            $_POST['SCShopRatings']['approved']
        );
    }

    public function actionProducts($showhidden = 0)
    {
        if (isset($_POST['SCRatings'])) {
            $id = $_POST['SCRatings']['rating_id'];

            $rating = SCRatings::find()
                ->where(['rating_id' => $id])
                  ->one();

            if ($rating->load(Yii::$app->request->post()) && $rating->save()) {
                Yii::$app->session->setFlash('success', 'Ответ сохранен');
            }
        }

        $query = SCRatings::find();

        if ($showhidden == 0) {
            $query->where('hidden = 0 OR hidden = ""');
        }

        $query->orderBy(['rating_id' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
              ->all();

        return $this->render('products', [
            'model'      => $model,
            'pages'      => $pages,
            'showhidden' => $showhidden
        ]);
    }
}
