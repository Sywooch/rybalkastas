<?php

namespace backend\controllers;

use Yii;
use common\models\SCOrders;
use common\models\SCOrdersSearch;

/**
 *
 * @author Dmitriy Mosolov
 * @version 1.0
 *
 */
class ShippingController extends \yii\web\Controller
{
    public function actionIndex() : string
    {
        $searchModel  = new SCOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['statusID' => 24]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionToShip($id) : string
    {
        $order = SCOrders::findOne($id);

        return $this->render('to-ship', [
            'order' => $order,
        ]);
    }
}
