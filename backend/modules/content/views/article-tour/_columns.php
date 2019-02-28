<?php
use yii\helpers\Url;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'picture',
        'format'=>'raw',
        'filter'=>false,
        'value'=>function($data){
            return "<img style='width: 75px' src='http://rybalkashop.ru$data->picture'/>";
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title_ru',
        'vAlign' => 'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'add_date',
        'vAlign' => 'middle',
        'value'=>function($data){
            return $data->date;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format'=>'raw',
        'attribute'=>'textMini',
        'vAlign' => 'middle',
        'value'=>function($data){
            $string = strip_tags($data->textMini);
            $string = substr($string, 0, 340);
            $string = substr($string, 0, strrpos($string, ' ')) . " ...";
            return $string;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'published',
        'width'=>'300px',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value'=>function($data){
            if($data->published == 1){
                return 'Опубликована';
            } else {
                return 'Черновик';
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sort_order',
        'format'=>'raw',
        'width'=>'100px',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value'=>function($data){
            return <<<HTML
<form action="" method="post">
    <input type="hidden" name="sort_id" value="$data->NID"/>
    <input type="text" class="form-control" name="sort_value" value="$data->sort_order"/>
</form> 
HTML;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];   