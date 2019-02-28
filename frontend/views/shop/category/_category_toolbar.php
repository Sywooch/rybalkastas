<?php
if(isset($_GET['onlyActions']) && $_GET['onlyActions'] == 1){
    $urlActions = \yii\helpers\Html::a('<i class="fa fa-times" aria-hidden="true"></i> Только акции', \yii\helpers\Url::current(['onlyActions'=>null]), ['class'=>'btn btn-rounded blue  active']);
} else {
    $urlActions = \yii\helpers\Html::a('<i class="fa fa-star" aria-hidden="true"></i> Только акции', \yii\helpers\Url::current(['onlyActions'=>1]), ['class'=>'btn btn-rounded  blue ']);
}


if(isset($_GET['onlyAvailable']) && $_GET['onlyAvailable'] == 1){
    $urlAvailable = \yii\helpers\Html::a('<i class="fa fa-times" aria-hidden="true"></i> Только в наличии', \yii\helpers\Url::current(['onlyAvailable'=>null]), ['class'=>'btn btn-rounded  blue  active']);
} else {
    $urlAvailable = \yii\helpers\Html::a('<i class="fa fa-cubes" aria-hidden="true"></i> Только в наличии', \yii\helpers\Url::current(['onlyAvailable'=>1]), ['class'=>'btn btn-rounded  blue ']);
}

if(isset($_GET['sort']) && $_GET['sort'] == 'minPrice'){
    $urlCheapToCost = \yii\helpers\Html::a('<i class="fa fa-times" aria-hidden="true"></i> От дешевых к дорогим', \yii\helpers\Url::current(['sort'=>null]), ['class'=>'btn btn-rounded  blue  active']);
} else {
    $urlCheapToCost = \yii\helpers\Html::a('<i class="fa fa-sort-amount-asc" aria-hidden="true"></i> От дешевых к дорогим', \yii\helpers\Url::current(['sort'=>'minPrice']), ['class'=>'btn btn-rounded  blue ']);
}

if(isset($_GET['sort']) && $_GET['sort'] == '-minPrice'){
    $urlCostToCheap = \yii\helpers\Html::a('<i class="fa fa-times" aria-hidden="true"></i> От дорогих к дешевым', \yii\helpers\Url::current(['sort'=>null]), ['class'=>'btn btn-rounded  blue  active']);
} else {
    $urlCostToCheap = \yii\helpers\Html::a('<i class="fa fa-sort-amount-desc" aria-hidden="true"></i> От дорогих к дешевым', \yii\helpers\Url::current(['sort'=>'-minPrice']), ['class'=>'btn btn-rounded  blue ']);
}



$sort_ar = [];
$sort_ar[null] = '<i class="fa fa-chevron-left"></i> Назад';
$sort_ar['minPrice'] = 'От дешевых к дорогим';
$sort_ar['-minPrice'] = 'От дорогих к дешевым';
//$sort_ar['name'] = 'По алфавиту А-Я';
//$sort_ar['-name'] = 'По алфавиту Я-А';

$current_sort = (!empty($_GET['sort'])?$sort_ar[$_GET['sort']]:$sort_ar[null]);
?>


<div class="category-toolbar text-center">
    <div class="btn-group btn-group-solid">
        <?=$urlCheapToCost?>
    </div>
    <div class="btn-group btn-group-solid">
        <?=$urlCostToCheap?>
    </div>
    <div class="btn-group btn-group-solid">
        <?=$urlAvailable?>
    </div>
    <div class="btn-group btn-group-solid">
        <?=$urlActions?>
    </div>
    <div class="clearfix"></div>
</div>