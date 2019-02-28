<?php
$monufacturer = \common\models\SCMonufacturers::find()->where(['name'=>$model->category->monufacturer])->one();
if(!empty($monufacturer)){

    $page = \common\models\SCSecondaryPages::find()->where(['brand'=>$monufacturer->id])->one();
    $view = $monufacturer->name;

    if(!empty($page)):?>


        <a href="<?=\yii\helpers\Url::to(['brands/index', 'alias'=>$page->alias])?>" class="btn btn-info btn-sm btn-flat btn-block text-uppercase buybtn nowrap">
            <small>Перейти в полный каталог</small><br/> <b><?=$view?></b> <i class="fa fa-chevron-right"></i>
        </a>
    <?php endif;
}
?>