<?php /* @var $cat common\models\SCCategories */ ?>

<?php

$action = Yii::$app->controller->action->id;
$m = \common\models\SCCategories::findOne($model['categoryID']);


$model = $m;
use yii\helpers\Html;

?>
<?php if ($model->meta->hasAction == 1): ?>
    <div class="ribbon"><span>Акция</span></div>
<?php endif; ?>

<?php if($model->isNew):?>
    <div class="ribbonNew"><span>NEW</span></div>
<?php endif;?>

<div class="item-card">
    <?php if(!empty(Yii::$app->session['showInfo']) && Yii::$app->user->can('contentField')):?>
        <a class="btn btn-circle green info-circle" href="#"><i class="fa fa-info" aria-hidden="true"></i></a>
        <div class="info-meta">
            <ul>
                <?php $meta = $model->meta;?>
                <li>ID: <?=$meta->categoryID?></li>
                <li>Количество дочерей: <?=$meta->countChildren?></li>
                <li>Количество всех дочерей: <?=$meta->countAllChildren?></li>
                <li>Количество товаров: <?=$meta->countProducts?></li>
                <li>Количество в наличии: <?=$meta->countInStock?></li>
                <li>Количество товаров со скидкой: <?=$meta->countActionInStock?></li>
                <li>Минимальная цена: <?=$meta->minPrice?></li>
                <li>Максимальная цена: <?=$meta->maxPrice?></li>
            </ul>
            <div class="col-md-12">
                <a target="_blank" href="<?=\Yii::$app->urlManagerBackend->createAbsoluteUrl(['categories/update', 'id'=>$model->categoryID])?>" class="btn btn-info btn-block btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i> Редактировать</a>
            </div>
        </div>
    <?php endif;?>
    <?php
        /*
         *     <a href="<?= \yii\helpers\Url::to([$action == 'actions' && !$model->isProduct ? 'shop/actions' : 'shop/category', 'id' => $model->categoryID, 'product' => ($model instanceof \common\models\SCProducts ? $model->productID : null)]) ?>"
         */
    ?>
    <?php if($model->meta->countChildren > 0 && empty($_GET['SCCategoriesSearchMicro'])){
        $url = \yii\helpers\Url::current(['id' => $model->categoryID, 'product' => ($model instanceof \common\models\SCProducts ? $model->productID : null)]);
    } else {
        $url = \yii\helpers\Url::to([$action == 'actions' && !$model->isProduct ? 'shop/actions' : 'shop/category', 'id' => $model->categoryID, 'product' => ($model instanceof \common\models\SCProducts ? $model->productID : null)]);
    }?>
    <a href="<?=$url ?>"
       class="name">
        <div class="img-wrap equal-height-img">
            <?php if (!empty($model->picture)): ?>
                <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt' => $model->name_ru]) ?>
            <?php else: ?>
                <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '250x250', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt' => $model->name_ru]) ?>
            <?php endif; ?>
            <?php if ($model->meta->countInStock == 0): ?>
                <div class="nis_overlay">
                    <span>Нет в наличии</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-right equal-height-meta">
            <?php if(isset($_GET['sort']) && $_GET['sort'] == '-minPrice'):?>
                <?php if (isset($model->meta) && $model->meta->minPrice > 0): ?>
                    <div class="minprice_label">
                        до <?= number_format($model->meta->maxPrice, 2) ?> руб.
                    </div>
                <?php endif; ?>
            <?php else:?>
                <?php if (isset($model->meta) && $model->meta->minPrice > 0): ?>
                    <div class="minprice_label">
                        от <?= number_format($model->meta->minPrice, 2) ?> руб.
                    </div>
                <?php endif; ?>
            <?php endif;?>
        </div>
        <div class="card-label equal-height">
            <?= $model->name_ru ?>
        </div>
    </a>
</div>
<div class="clearfix"></div>