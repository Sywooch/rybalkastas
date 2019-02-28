<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 29.05.2017
 * Time: 11:42
 */
use yii\helpers\Html;



$productsInside = Yii::$app->cache->getOrSet('productsInside_'.$model->categoryID.'_new_4', function () use ($model) {
    return \common\models\SCCategories::findInnerProducts($model->categoryID, true)->orderBy('productID DESC')->limit(4)->all();
});


?>

<?php if(!empty($productsInside)):?>
    <div class="item-holder catalog-block box-rs">
        <h3>Новые поступления</h3>
        <div class="items row-eq-height">
            <?php foreach($productsInside as $m):?>
                <?php $model = \common\models\SCProducts::findOne($m['productID']);?>
                <?php if(empty($model)){
                    continue;
                }?>
                <div class="item col-md-3 col-xs-6">
                    <div class="item-card">
                        <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$m['categoryID'], 'product'=>($m instanceof \common\models\SCProducts?$m['productID']:null)])?>" class="name">
                            <div class="img-wrap equal-height-img">
                                <?php if(!empty($model->picture)):?>
                                    <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$model->picture, '250x250', Yii::$app->settings->get('image', 'category'), false, 'categories'), ['alt'=>$model->name_ru])?>
                                <?php else:?>
                                    <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '250x250', Yii::$app->settings->get('image', 'category'), false, 'common'), ['alt'=>$m['name_ru']])?>
                                <?php endif;?>
                            </div>
                            <div class="text-right equal-height-meta">
                                <div class="minprice_label">
                                    от <?=number_format($model->actualPrice,2)?> руб.
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
