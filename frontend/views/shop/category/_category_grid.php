<?php

/* @var $cat common\models\SCCategories */

use \yii\helpers\Url;
use common\models\SCCategories;
use \common\models\SCProducts;

$action = Yii::$app->controller->action->id;
$cache  = Yii::$app->cache;

$m = SCCategories::findOne($model['categoryID']);

$product = null;

if(!empty($model['productID'])){
    $product = SCProducts::findOne($model['productID']);
}

$model = $m;

if (empty($model)) {
    return;
}

?>

<?php if ((isset($model->meta->hasAction) && $model->meta->hasAction == 1) || $model->meta->countActionInStock > 0): ?>
    <div class="ribbon"><span>Акция</span></div>
<?php endif; ?>

<?php if($model->isNew):?>
    <div class="ribbonNew"><span>NEW</span></div>
<?php endif;?>

<div class="item-card">
    <?php if (!empty(Yii::$app->session['showInfo']) && Yii::$app->user->can('contentField')): ?>
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
                <a target="_blank" href="<?=\Yii::$app->urlManagerBackend->createAbsoluteUrl(['categories/update', 'id'=>$model->categoryID])?>"
                   class="btn btn-info btn-block btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i> Редактировать
                </a>
            </div>
        </div>
    <?php endif;?>

    <?php /*
     <a href="<?= \yii\helpers\Url::to([$action == 'actions' && !$model->isProduct ? 'shop/actions' : 'shop/category', 'id' => $model->categoryID, 'product' => ($model instanceof \common\models\SCProducts ? $model->productID : null)]) ?>"
     */ ?>

    <?php if ($model->meta->countChildren > 0 && empty($_GET['SCCategoriesSearchMicro'])) {
        $url = Url::current([
            'id'      => $model->categoryID,
            'product' => ($model instanceof SCProducts ? $model->productID : null)
        ]);
    } else {
        $url = Url::to([
            $action == 'actions' && !$model->isProduct ? 'shop/actions' : 'shop/category',
            'id'      => $model->categoryID,
            'product' => ($model instanceof SCProducts ? $model->productID : null)
        ]);
    } ?>

    <?= $this->render('grids/_category', [
        'model'   => $model,
        'product' => $product,
        'url'     => $url,
        'action'  => $action
    ]); ?>
</div>

<div class="clearfix"></div>
