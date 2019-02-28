<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 12:01
 */

/* @var $model common\models\SCCategories */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $products array */
use kartik\widgets\SwitchInput;



$this->title = $model->name_ru;
foreach ($model->path as $item){
    if($item['id']==$model->categoryID)continue;
    $this->params['breadcrumbs'][] = ['label'=>$item['name'],'url'=>\yii\helpers\Url::to(['shop/category', 'id'=>$item['id']])];
}
$this->params['breadcrumbs'][] = $model->name_ru;

?>

<div class="text-center">
    <img src="http://odkb76.ru/pic/userfile/images/razrabotka.png" />
    <hr>
    <a class="btn btn-lg btn-flat btn-primary btn-block" href="#" onclick="history.go(-1)">Вернуться назад</a>
</div>
