<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 10.04.2017
 * Time: 9:39
 */

$this->title = "Консультации экспертов";
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="page-header text-center">
    Эксперты Rybalkashop.ru
</h1>

<div class="container">
    <div class="row row-eq-height">
        <?php foreach($model as $m):?>
            <a class="col-md-4 expert" href="<?=\yii\helpers\Url::to(['experts/expert', 'id'=>$m->expert_id])?>">
                <div class="expert_grid">
                <img src="<?=Yii::$app->imageman->load('/experts/'.$m->picture, '250x250', 100, false, 'expert_circles', true)?>" class="img-circle center-block">
                <h3 class="text-center"><?=$m->expert_name.' '.$m->expert_last_name?></h3>
                <p class="text-center"><?=$m->shop?></p>
                </div>
            </a>
        <?php endforeach;?>
    </div>
</div>
