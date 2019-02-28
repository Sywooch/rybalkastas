<?php use yii\helpers\Html?>


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
        <div class="minprice_label">
            <?=number_format($product->Price,2 )?> руб.
        </div>
    </div>

    <div class="card-label equal-height">
        <span><?= $product->name_ru ?></span>
    </div>
</a>