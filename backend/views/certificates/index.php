<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SCCertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарочные сертификаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sccertificates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'certificateNumber',
            'certificateCode',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'certificateRating',
                'value' => function ($data) {
                    return $data->certificateRating.' руб.';
                }
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'certificateUsed',
                'value' => function ($data) {
                    if($data->certificateUsed == 1){
                        return 'Использован';
                    } else {
                        return 'Новый';
                    }
                }
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'format'=>'raw',
                'value' => function($data){
                    return '<a href="'.\yii\helpers\Url::to(['update', 'id'=>$data->certificateID]).'" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
                }
            ],
        ],
    ]); ?>
</div>
