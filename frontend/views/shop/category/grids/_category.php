<?php

use yii\helpers\Html;

?>

<a href="<?= $url ?>" class="name">
    <div class="img-wrap equal-height-img">
        <?php if (!empty($model->picture)): ?>
            <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt' => $model->name_ru]) ?>
        <?php else: ?>
            <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '250x250', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt' => $model->name_ru]) ?>
        <?php endif; ?>
        <?php if ($model->meta->countInStock == 0): ?>
            <?php if (empty($model->na_message)): ?>
                <div class="nis_overlay">
                    <span>Нет в наличии</span>
                </div>
            <?php else: ?>
                <div class="nis_custom">
                    <span><?= $model->na_message ?></span>
                </div>
            <?php endif;?>
        <?php endif; ?>
    </div>

    <div class="text-right equal-height-meta">
        <?php if (isset($_GET['sort']) && $_GET['sort'] == '-minPrice'): ?>
            <?php if (isset($model->meta) && $model->meta->minPrice > 0): ?>
                <div class="minprice_label">
                    до <?= number_format($model->meta->maxPrice, 2) ?> руб.
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if (isset($model->meta) && $model->meta->minPrice > 0): ?>
                <div class="minprice_label">
                    <?php if (!empty($model->meta->minListPrice) && $model->meta->minListPrice > $model->meta->minPrice): ?>
                        <div class="minlistprice_label">
                            от <?= number_format($model->meta->minListPrice, 2) ?> руб.
                        </div>
                    <?php endif;?>
                    от <?= $action == 'actions' ? number_format($model->meta->minActionPrice, 2) : number_format($model->meta->minPrice, 2) ?> руб.
                </div>
            <?php endif; ?>
        <?php endif;?>
    </div>

    <div class="card-label equal-height">
        <span><?= $model->name_ru ?></span>
    </div>
</a>