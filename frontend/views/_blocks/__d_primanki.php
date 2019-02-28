<?php

use yii\helpers\Html;

$ids = [7552, 8359];

$models = \common\models\SCCategories::find()
      ->where(['in', 'categoryID', $ids])
    ->orderBy('sort_order ASC')
        ->all();

?>

<?php foreach ($models as $m): ?>
    <div class="item col-md-3 col-xs-6 included">
        <?php if ($m->meta->hasAction == 1): ?>
            <div class="ribbon"><span>Акция</span></div>
        <?php endif; ?>
        <div class="item-card">
            <a href="<?= \yii\helpers\Url::to(['shop/category', 'id'=>$m->categoryID]) ?>" class="name">
                <div class="img-wrap">
                    <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru]) ?>
                </div>
                <div class="card-label equal-height">
                    <?= $m->name_ru ?>
                </div>
            </a>
        </div>
    </div>
<?php endforeach;?>
