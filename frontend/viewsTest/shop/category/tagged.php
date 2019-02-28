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
use yii\helpers\Html;

if(!empty($monufacturer) && !empty($tag)){
    $this->title = $model->name_ru.' '.$monufacturer.' с тегом "'.\common\models\SCTags::find()->where(['slug'=>$tag])->one()->name.'"';
    $header = $model->name_ru.' '.$monufacturer.' с тегом "'.\common\models\SCTags::find()->where(['slug'=>$tag])->one()->name.'"';
} elseif(!empty($monufacturer)){
    $this->title = $model->name_ru.' '.$monufacturer;
    $header = $model->name_ru.' '.$monufacturer;
} else {
    $this->title = $model->name_ru.' с тегом "'.\common\models\SCTags::find()->where(['slug'=>$tag])->one()->name.'"';
    $header = $model->name_ru.' с тегом "'.\common\models\SCTags::find()->where(['slug'=>$tag])->one()->name.'"';
}


$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description_ru,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->meta_keywords_ru,
]);






$route = 'shop/category';

foreach ($model->path as $item) {
    if ($item['id'] == $model->categoryID) continue;
    $this->params['breadcrumbs'][] = ['label' => $item['name'], 'url' => \yii\helpers\Url::to([$route, 'id' => $item['id']])];
}
$this->params['breadcrumbs'][] = ['label' => $model->name_ru, 'url' => \yii\helpers\Url::to([$route, 'id' => $model->categoryID])];
if(!empty($monufacturer)){
    $this->params['breadcrumbs'][] = ['label'=>'<b class="text-success">Бренд "'.$monufacturer.'"</b>','encode'=>false];
}

if(!empty($tag)){
    $this->params['breadcrumbs'][] = ['label'=>'<b class="text-warning">Тэг "'.\common\models\SCTags::find()->where(['slug'=>$tag])->one()->name.'"</b>','encode'=>false];
}

?>

<div class="category">
    <div class="text-center">
        <div class="fancy-title title-dotted-border title-center">
            <h1><?= $header ?></h1>
        </div>
    </div>
    <?php if (!empty($model->head_picture)): ?>
        <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->head_picture, '955x250', Yii::$app->settings->get('image', 'headPicture'), false, 'cathead'), ['alt' => $model->name_ru, 'class' => 'category_head_picture img-thumbnail']) ?>
    <?php endif; ?>
    <div>


    </div>
    <div class="clearfix"></div>
    <?php if($viewparams['mons'] == 1 && !empty($model->monsInside)):?>
        <div class="text-center tagheader">
            Производители:
        </div>
        <div id="monsFlow" class="text-center">
            <?php foreach($model->monsInside as $k=>$mon):?>
                    <a href="<?=\yii\helpers\Url::current(['monufacturer'=>$k])?>" class="btn btn-xs btn-rounded blue-madison btn-tag  <?php if(!empty($_GET['monufacturer']) && $_GET['monufacturer']==$k)echo 'active'?>">
                        <?=$mon?> </a>
            <?php endforeach;?>
            <?php if(!empty($_GET['monufacturer'])):?>
                <a href="<?=\yii\helpers\Url::current(['monufacturer'=>null])?>" class="btn btn-xs btn-rounded red-pink btn-tag  <?php if(!empty($_GET['monufacturer']) && $_GET['monufacturer']==$k)echo 'active'?>">
                    <i class="fa fa-times"></i>
                </a>
            <?php endif;?>
        </div>
        <hr/>
    <?php endif;?>
    <?php if($viewparams['tags'] == 1 && !empty($model->tagsInside)):?>
        <div class="text-center tagheader">
            Теги:
        </div>
        <div id="tagsFlow" class="text-center">
            <?php foreach($model->tagsInside as $k=>$tag):?>
                    <a href="<?=\yii\helpers\Url::current(['tag'=>$k])?>" class="btn btn-xs btn-rounded blue-steel btn-tag <?php if(!empty($_GET['tag']) && $_GET['tag']==$k)echo 'active'?>">
                        #<?=$tag?> </a>
            <?php endforeach;?>
            <?php if(!empty($_GET['tag'])):?>
                <a href="<?=\yii\helpers\Url::current(['tag'=>null])?>" class="btn btn-xs btn-rounded red-pink btn-tag  <?php if(!empty($_GET['monufacturer']) && $_GET['monufacturer']==$k)echo 'active'?>">
                    <i class="fa fa-times"></i>
                </a>
            <?php endif;?>
        </div>
    <?php endif;?>
    <div class="toolbar-block">
        <?php if(Yii::$app->user->can('Employee')):?>
        <?= $this->render('//_admin_blocks/category/_toolbar', ['model' => $model]); ?>
        <?php endif;?>
        <?=$this->render('_category_toolbar')?>

        <?php if ($model->show_filter == 1): ?>
            <div id="filter_in_category">
            </div>
        <?php endif; ?>
    </div>
    <div class="catalog-block">
        <div class="item-holder">
            <div class="">

                <?php

                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_category_grid',
                        'itemOptions' => ['class' => 'item col-md-3 col-xs-6'],
                        'id' => 'my-listview-id',
                        'layout' => "<div class=\"items row-eq-height\">{items}</div>\n<div class='clearfix'> </div>{pager}",
                    ]);


                ?>
            </div>

        </div>

        <hr>

        <hr>
        <div class="text-justify">
            <?=$model->description_ru?>
        </div>

        <hr>
        <?=$this->render('_category_new_additions', ['model'=>$model]);?>

        <hr>
        <?=$this->render('_category_specials', ['model'=>$model]);?>
    </div>
</div>


<?php
$js = <<<JS
    $('#infiniteChanger').on('change','#toggleInfinite',function(){
        $('#infiniteChanger').submit();
    });
JS;

$this->registerJs($js);
?>

