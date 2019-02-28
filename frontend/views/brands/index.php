<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 06.04.2017
 * Time: 14:25
 */

use yii\helpers\Html;


$this->title = $model->name;
$this->params['breadcrumbs'][] = 'Бренд ' . $model->name;

$news = \common\models\SCNewsTable::find()->where(['brand' => $model->brand])->orderBy('NID DESC')->limit(12)->all();

?>

    <div class="brandpage">
        <div class="text-center">
            <h1 class="page-header"><?= $model->name ?></h1>
        </div>
        <div>
            <?php if (!empty($model->head_image)): ?>
                <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->head_image, '918x231', 60, false, 'brandhead'), ['alt' => $model->name, 'class' => 'category_head_picture img-thumbnail']) ?>
            <?php endif; ?>
        </div>

        <hr/>

        <?php if(!empty($news)):?>
        <div class="catalog-block">
            <div class="wrapper">
                <h4>Новости <?= $model->name ?></h4>
            </div>
            <div class="news-slider owl-theme">
                <?php foreach ($news as $n):?>
                <div class="item">
                    <img style="" src="<?=\frontend\helpers\ImageHelper::loadImageAbs($n->picture)?>" class="img-responsive">

                    <div class="date"><i class="fa fa-calendar" aria-hidden="true"></i> <?=Yii::$app->formatter->asRelativeTime($n->published_at)?></div>
                    <div class="caption">
                        <?=substr(rtrim(substr(strip_tags($n->textMini),0,200), "!,.-"), 0, strrpos(rtrim(substr(strip_tags($n->textMini),0,200), "!,.-"), ' '))?>...
                    </div>
                    <div class="more_bn">
                        <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>">Читать дальше</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif;?>



        <?php $latest = \common\models\SCCategories::find()->orderBy('categoryID DESC')->where(['<>', 'picture', ''])->andWhere(['monufacturer'=>$model->brandName])->limit(4)->all(); ?>

        <div class="catalog-block voffset4">
            <h4>Новые поступления <?= $model->name ?></h4>
            <div class="item-holder">
                <div class="row text-center">
                    <?php foreach ($latest as $m):?>
                        <div class="item col-md-3 col-xs-6">
                            <div class="item-card">
                                <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID])?>" class="name">
                                    <div class="img-wrap">
                                        <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '200x200', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru])?>
                                    </div>
                                    <div class="text-right equal-height-meta">
                                        <div class="minprice_label">
                                            от <?=number_format($m->meta->minPrice,2)?> руб.
                                        </div>
                                    </div>
                                    <div class="card-label equal-height">
                                        <?=$m->name_ru?>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php endforeach;?>
                </div>
            </div>
        </div>

        <?php
        $q1 = \common\models\SCCategories::find()->select('categoryID')->where(['<>', 'picture', ''])->andWhere(['monufacturer'=>$model->brandName])->asArray();
        $q2 = \common\models\SCProducts::find()->where(['in', 'categoryID', $q1])->andWhere('Price < list_price')->orderBy('RAND()')->limit(4);


        $q2 = $q2->all();
        ?>

        <div class="catalog-block voffset4">
            <h4>Специальные предложения <?= $model->name ?></h4>
            <div class="item-holder">
                <div class="row text-center">
                    <?php foreach ($q2 as $m):?>
                        <div class="item col-md-3 col-xs-6">
                            <div class="item-card">
                                <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID, 'product'=>$m->productID])?>" class="name">
                                    <div class="img-wrap">
                                        <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picurl, '200x200', Yii::$app->settings->get('image', 'category'), false, 'products'), ['alt'=>$m->name_ru])?>
                                    </div>
                                    <div class="text-right equal-height-meta">
                                        <div class="minprice_label">
                                            <span class="label_old_price"><?=number_format($m->list_price,2)?> руб.</span><?=number_format($m->Price,2)?> руб.
                                        </div>
                                    </div>
                                    <div class="card-label equal-height">
                                        <?=$m->name_ru?>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php endforeach;?>
                </div>
            </div>
        </div>

        <?php
        $containers = \common\models\SCSecondaryPagesContainers::find()->select('id')->where(['pageid'=>$model->id]);
        $links = \common\models\SCSecondaryPagesLinks::find()->where(['in','page_id', $containers])->orderBy('sort_order ASC')->all();
        ?>

        <div class="catalog-block voffset4">
            <h4>Каталог <?= $model->name ?></h4>
            <div class="item-holder">
                <div class="row row-eq-height text-center">
                    <?php foreach ($links as $l):?>
                        <?php if(!empty($l->categoryID)):?>
                            <?=$this->render('_category', ['l'=>$l])?>
                        <?php else:?>
                            <?=$this->render('_custom', ['l'=>$l])?>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>

        <div class="catalog-block voffset4">
            <h4>Описание бренда <?= $model->name ?></h4>
            <div>
                <?= $model->description ?>
            </div>
        </div>

    </div>

<?php $js = <<<JS
$('.news-slider').owlCarousel({
        loop:true,
        margin:5,
        nav:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        },
        navText: ["Назад","Вперед"],
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });
JS;
$this->registerJs($js); ?>