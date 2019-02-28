<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 29.05.2017
 * Time: 11:42
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


$productsInside = Yii::$app->cache->getOrSet('productsInside_'.$model->categoryID, function () use ($model) {
    $products = \common\models\SCCategories::findInnerProducts($model->categoryID)->all();
    return ArrayHelper::getColumn($products, 'productID');
});

/*$products = Yii::$app->cache->getOrSet('productsInside_'.$model->categoryID.'_specials_4', function () use ($productsInside) {
    $products = \common\models\SCProducts::find()->where(['in', 'productID', $productsInside])->andWhere('list_price > Price')->limit(4)->all();
    return $products;
});*/

$products = \common\models\SCProducts::getDb()->cache(function ($db) use($productsInside) {
    return \common\models\SCProducts::find()->where(['in', 'productID', $productsInside])->andWhere('list_price > Price')->limit(4)->all();
});






?>

<?php if(!empty($products)):?>
    <div class="item-holder catalog-block box-rs">
        <h3>Специальные предложения</h3>
        <div class="items row-eq-height">
            <?php foreach($products as $m):?>
                <div class="item col-md-3 col-xs-6">
                    <div class="item-card">
                        <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m['categoryID'], 'product'=>($m instanceof \common\models\SCProducts?$m['productID']:null)])?>" class="name">
                            <div class="img-wrap equal-height-img">
                                <?php if(!empty($model->picture)):?>
                                    <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$m->name_ru])?>
                                <?php else:?>
                                    <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '250x250', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt'=>$m['name_ru']])?>
                                <?php endif;?>
                            </div>
                            <div class="text-right equal-height-meta">
                                <div class="minprice_label">
                                    от <?=number_format($m->actualPrice,2)?> руб.
                                </div>
                            </div>
                            <div class="card-label text-center equal-height">
                                <?=$m['name_ru']?>
                            </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>
