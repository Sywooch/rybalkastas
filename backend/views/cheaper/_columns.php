<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'customerID',
        'format' => 'raw',
        'value' => function($data){
            $customer = \common\models\SCCustomers::find()->where("customerID = $data->customerID")->one();
            $name = $customer->first_name.' '.$customer->last_name;
            return \yii\helpers\Html::a($name, Url::toRoute(['/orders/user', 'id'=>$data->customerID]),
                [
                    'target'=>'_blank',
                    'class'=>'richbich',
                    'data-pjax'=>'false',
                ]);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'productID',
        'format' => 'raw',
        'value' => function($data){
            $product = \common\models\SCProducts::find()->where("productID = $data->productID")->one();
            return \yii\helpers\Html::a($product->name_ru, "http://rybalkashop.ru/index.php?categoryID=$product->categoryID&product=$product->productID",
                [
                    'target'=>'_blank',
                    'class'=>'richbich',
                    'data-pjax'=>'false',
                ]);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
        'format' => 'raw',
        'value' => function($data){
            return "<a href='$data->url'>$data->url</a>";
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   