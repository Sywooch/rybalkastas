<?php

namespace backend\modules\interaction\controllers;

use common\models\api\ChatOperatorConnections;
use common\models\SCExperts;
use common\models\SCProductRequest;
use yii\web\Controller;
use Yii;

class RequestsController extends Controller
{
    public function actionIndex()
    {
        $reqs = SCProductRequest::findBySql("SELECT *, (SELECT COUNT(productID) FROM SC_product_request WHERE productID = scpr.productID) as count FROM SC_product_request as scpr WHERE 1_wave_sent = 0 GROUP BY productID ORDER BY count DESC")->all();
        $reqsSent = SCProductRequest::findBySql("SELECT *, (SELECT COUNT(productID) FROM SC_product_request WHERE productID = scpr.productID) as count FROM SC_product_request as scpr WHERE 1_wave_sent = 1 GROUP BY productID ORDER BY count DESC")->all();
        return $this->render('index', ['reqs'=>$reqs, 'reqsSent'=>$reqsSent]);
    }


}
