<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 14.09.2017
 * Time: 7:52
 */

$monufacturer = \common\models\SCMonufacturers::find()->where(['name'=>$model->monufacturer])->one();
if(!empty($monufacturer)){

    $page = \common\models\SCSecondaryPages::find()->where(['brand'=>$monufacturer->id])->one();
    $view = $monufacturer->name;

    if(!empty($page) && !empty($page->link_image)):?>
            <a class="brandicon" data-pjax="false" href="<?=\yii\helpers\Url::to(['brands/index', 'alias'=>$page->alias])?>">
                <?=\yii\helpers\Html::img(Yii::$app->imageman->load('/brand_pictures/'.$page->link_image, '120x40', 80, false, 'brand'));?>
            </a>
    <?php endif;
}
