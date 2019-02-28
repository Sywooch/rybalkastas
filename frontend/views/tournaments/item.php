<?php
$this->title = $model->title_ru;
$this->params['breadcrumbs'][] = ['url'=>\yii\helpers\Url::to(['/tournaments/index']),'label'=>"Участие в соревнованиях"];
$this->params['breadcrumbs'][] = $model->title_ru;
?>
<div class="news-page">
    <div class="text-center">
        <h1 class="page-header"><?=$model->title_ru?> <small>Участие Rybalkashop в соревнованиях</small></h1>
    </div>
    <div class="col-md-12 text-justify">
        <img style="float: left;width: 30%;padding-right: 10px;" src="<?=\frontend\helpers\ImageHelper::loadImageAbs($model->picture)?>" class="img-responsive">
        <?=$model->textToPublication_ru?>
    </div>
</div>
<div class="col-md-12">
    <div class="clearfix"></div>
    <a href="<?=\yii\helpers\Url::to(['/tournaments/index'])?>" class="btn btn-primary pull-right">Вернуться</a>
</div>