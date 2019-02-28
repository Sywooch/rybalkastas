<?php
$this->title = $model->title_ru;
?>
<div class="news-page blackfriday">
    <div class="text-center">
        <h1 class="page-header"><?=$model->title_ru?> <small>Новости Rybalkashop</small></h1>
    </div>
    <div class="col-md-12 text-justify">
        <img style="width: 100%;padding-right: 10px;" src="<?=\frontend\helpers\ImageHelper::loadImageAbs($model->picture)?>" class="img-responsive">
        <?=$model->textToPublication_ru?>
    </div>
    <div class="clearfix"></div>
</div>
