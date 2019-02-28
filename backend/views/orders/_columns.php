<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'orderID',
        'format' => 'raw',


        'value' => function($data){
            return \yii\helpers\Html::a(sprintf("%08d", $data->orderID), Url::toRoute(['/orders/view', 'id'=>$data->orderID]),
                [
                    'role'=>"modal-remote",
                    'data-pjax'=>'0',
                ]);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Номер 1C',
        'attribute'=>'id_1c',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'order_time',
        'width' => '160px',
        'value' => function($data){
            return Yii::$app->formatter->asDatetime(strtotime($data->order_time));
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'customer',
        'format' => 'raw',
        'value' => function($data){
            return \yii\helpers\Html::a($data->customer, Url::toRoute(['/orders/user', 'id'=>$data->customerID]),
                [
                    'target'=>'_blank',
                    'class'=>'richbich',
                    'data-pjax'=>'false',
                ]);
        },
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'filter' => ArrayHelper::map(\common\models\SCOrders::find()->where("payment_type <> ''")->asArray()->all(), 'payment_type', 'payment_type'),
        'attribute'=>'payment_type',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => ArrayHelper::map(\common\models\SCOrders::find()->where("shipping_type <> ''")->asArray()->all(), 'shipping_type', 'shipping_type'),
        'attribute'=>'shipping_type',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => ArrayHelper::map(\common\models\SCShippingMethods::find()->asArray()->all(), 'Name_ru', 'Name_ru'),
        'attribute'=>'shipping_type',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => ArrayHelper::map(\common\models\SCPaymentTypes::find()->asArray()->all(), 'Name_ru', 'Name_ru'),
        'attribute'=>'payment_type',
    ],
    [
     'class'=>'\kartik\grid\DataColumn',
     'attribute'=>'order_amount',
        'value' => function($data){
            return $data->order_amount.' руб.';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => ArrayHelper::map(\common\models\SCOrderStatus::find()->asArray()->all(), 'statusID', 'status_name_ru'),
        'attribute'=>'statusID',
        'value' => function($data){
            return \common\models\SCOrderStatus::find()->where("statusID = $data->statusID")->one()->status_name_ru;
        },
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'containsItem',
        'format' => 'html',
        'value' => function ($model) {
            $products = '';
            foreach ($model->products as $key => $prd) {
                if ($key !== 0) {
                    $products .= '';
                }
                if(empty($prd->product))continue;
                $products .= $prd->product->product_code.',';
            }
            return '';
        },
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Ответственный',
        'attribute'=>'manager_id',
        'filter' => ArrayHelper::map(\common\models\SCExperts::find()->asArray()->all(), 'expert_id', 'expert_fullname'),
        //'format' => 'html',
        'value' => function ($model) {
            if(empty($model->manager_id)){
                return '(Не найден)';
            } else {
                return \common\models\SCExperts::findOne($model->manager_id)->expert_fullname;
            }
        },
    ],
    [
        'label'=>'Источник',
        'format' => 'html',
        'value' => function ($model) {
            if(empty($model->source_ref)){
                return '<b class="text-warning">Обычный</b>';
            } elseif($model->source_ref == "spdir"){
                return '<b class="text-success">Direct</b>';
            } elseif($model->source_ref == "dir"){
                return '<b style="color:#bf4f00">YDirect</b>';
            } elseif($model->source_ref == "ymrkt"){
                return '<b style="color:#bf0078">Market</b>';
            } elseif($model->source_ref == "rf"){
                return '<b style="color:#2c3dbf">RosFishing</b>';
            }else {
                return '<b class="text-danger">Неизвестно</b>';
            }
        },
    ],
    [
        'label'=>'Выгрузить в 1С',
        'format' => 'html',
        'value' => function ($model) {
            if(empty($model->{'id_1c'})){
                return '<a href="'.Url::to(['upload', 'id'=>$model->orderID]).'" class="btn btn-success btn-xs"><i class="fa fa-play"></i> Выгрузить в 1с</a>';
            } else {
                return '<i class="text-success">выгружен</i>';
            }
        },
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_module_id',
    // ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'payment_module_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customers_comment',
    // ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_cost',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'order_discount',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'discount_description',
    // ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'currency_code',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'currency_value',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_firstname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_lastname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'customer_email',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_firstname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_lastname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_country',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_state',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_zip',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_city',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shipping_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_firstname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_lastname',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_country',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_state',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_zip',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_city',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'billing_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cc_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cc_holdername',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cc_expires',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cc_cvv',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'affiliateID',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shippingServiceInfo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'google_order_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'source',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_1c',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'user_phone',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'manager_id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['style'=>'display:none'],
        'deleteOptions'=>['style'=>'display:none'],
    ],

];

?>
