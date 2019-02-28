<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.05.2017
 * Time: 11:49
 */

$request = new \yii\web\Request(['url' => parse_url(Yii::$app->request->referrer, PHP_URL_PATH)]);
$url = Yii::$app->urlManager->parseRequest($request);
$action = $url[0];

if($action == 'shop/actions'){
    $this->params['breadcrumbs'][] = ['label'=>'Распродажа', 'url'=>['shop/actions']];
    $route = 'shop/actions';
} else {
    $route = 'shop/category';
}

foreach ($model->path as $item) {
    if ($item['id'] == $model->categoryID) continue;
    $this->params['breadcrumbs'][] = ['label' => $item['name'], 'url' => \yii\helpers\Url::to([$route, 'id' => $item['id']])];
}
$this->params['breadcrumbs'][] = $model->name_ru;

