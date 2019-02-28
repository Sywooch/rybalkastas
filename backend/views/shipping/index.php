<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \common\models\SCOrders */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Отгрузка';

try {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'orderID',
                'format'    => 'raw',
                'value'     => function($data) {
                    return Html::a(sprintf("%08d", $data->orderID), Url::toRoute([
                        '/shipping/to-ship', 'id' => $data->orderID
                    ]));
                },
            ],
            'order_time',
            'shipping_type',
        ]
    ]);
} catch (Exception $exception) {
    echo $exception->getMessage();
}
