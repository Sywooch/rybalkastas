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

/*$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description_ru,
]);*/

// ++ ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО
$lowestPrice = $model->meta->minPrice." руб.";
$name = trim($model->name_ru);
$this->registerMetaTag([
    'name' => 'description',
    'content' => "✔ Купить $name с быстрой доставкой по Москве ❤ Большой ассортимент и выгодные цены от $lowestPrice ☎ Звоните 8 499 707-11-14 !",
]);
// -- ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->meta_keywords_ru,
]);

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::to(['/shop/category', 'id'=>$model->getPrimaryKey()], true)]);


$header = $model->name_ru;

if($model->categoryID == 1){


    $this->title = "Главный раздел";
    $header = "Главный раздел";
}else{


    $this->title = $model->meta_title_ru;

    // ++ ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО
    //$this->title = "$model->name_ru: цены - купить в интернет магазине в Москве";
    // -- ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО
}

$action = Yii::$app->controller->action->id;
if($action == 'actions'){

    if($model->categoryID == 1){
        $this->title = "Распродажа рыболовных снастей";
        $header = "Распродажа";

    } else {
        $this->params['breadcrumbs'][] = ['label'=>'Распродажа', 'url'=>['shop/actions']];
    }

    $route = 'shop/actions';
} else {
    $route = 'shop/category';
}

foreach ($model->path as $item) {
    if ($item['id'] == $model->categoryID) continue;
    $this->params['breadcrumbs'][] = ['label' => $item['name'], 'url' => \yii\helpers\Url::to([$route, 'id' => $item['id']])];
}
$this->params['breadcrumbs'][] = $header;

if($action == 'actions'){
    $this->title = $this->title." - Акции";
}
Yii::trace("1", 'traceFreq');

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

    <?php Yii::trace("1.1", 'traceFreq');?>
    <div>


    </div>
    <div class="clearfix"></div>
    <?php if($model->show_monsflow && !empty($model->monsInside)):?>
        <div class="text-center">
            Производители:
        </div>
        <div id="monsFlow" class="text-center">
            <?php foreach($model->monsInside as $k=>$mon):?>
                <a href="<?=\yii\helpers\Url::to(['tagged','id'=>$model->categoryID,'monufacturer'=>$k])?>" class="btn btn-xs btn-rounded blue-madison btn-tag  <?php if(!empty($_GET['monufacturer']) && $_GET['monufacturer']==$k)echo 'active'?>">
                    <?=$mon?> </a>
            <?php endforeach;?>
        </div>
    <?php endif;?>

    <?php Yii::trace("1.2", 'traceFreq');?>

    <?php if($model->show_tagsflow && !empty($model->tagsInside)):?>
        <div class="text-center">
            Теги:
        </div>
        <div id="tagsFlow" class="text-center">
            <?php foreach($model->tagsInside as $k=>$tag):?>
                <?php
                /*$ch = \common\models\SCTags::find()->where(['slug'=>\yii\helpers\Inflector::slug($tag)])->one();
                if(empty($ch)){
                    $ch = new \common\models\SCTags();
                    $ch->name = $tag;
                    $ch->slug = \yii\helpers\Inflector::slug($tag);
                    $ch->save();
                }*/
                ?>
                <a href="<?=\yii\helpers\Url::to(['tagged','id'=>$model->categoryID,'tag'=>$k])?>" class="btn btn-xs btn-rounded blue-steel btn-tag <?php if(!empty($_GET['tag']) && $_GET['tag']==$k)echo 'active'?>">
                    #<?=$tag?> </a>
            <?php endforeach;?>
        </div>
    <?php endif;?>

    <?php Yii::trace("2", 'traceFreq'); ?>

    <div class="toolbar-block">
        <?php if(Yii::$app->user->can('Employee')):?>
        <?= $this->render('//_admin_blocks/category/_toolbar', ['model' => $model]); ?>
        <?php endif;?>
        <?=$this->render('_category_toolbar')?>
        <?php if ($model->show_filter == 1): ?>
            <div id="filter_in_category">
            </div>
        <?php endif; ?>

        <?php Yii::trace("3", 'traceFreq'); ?>
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

        <?php Yii::trace("4", 'traceFreq'); ?>

        <hr>
        <?=$this->render('_category_new_additions', ['model'=>$model]);?>

        <?php Yii::trace("5", 'traceFreq'); ?>

        <hr>
        <?=$this->render('_category_specials', ['model'=>$model]);?>

        <?php Yii::trace("6", 'traceFreq'); ?>
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

