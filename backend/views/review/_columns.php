<?php

use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'title_ru',
        'vAlign' => 'middle',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'vAlign' => 'middle',
        'value' => function($model){
            return $model->created_at;
        }
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'Просмотр',
            'data-toggle' => 'tooltip'
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Изменить',
            'data-toggle' => 'tooltip'
        ],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title'=>'Удалить',
            'data-confirm' => false,
            'data-method' => false,
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
        ],
    ],
];
