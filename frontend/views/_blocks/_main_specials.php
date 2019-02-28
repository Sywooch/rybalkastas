<?php

use common\models\SCProducts;
use common\models\SCSpecialsSlider;
use frontend\assets\IndexAsset;

$cache = Yii::$app->cache;

IndexAsset::register($this);

$idsRaw = $cache->getOrSet('productIDs4', function () {
    $b = SCProducts::find()
         ->select(['productID'])
          ->where('Price <= (list_price/100)*70')
        ->asArray()
            ->all();

    return \yii\helpers\ArrayHelper::getColumn($b,'productID');
});

$keys = array_rand($idsRaw, 50);
$ids = [];
foreach($keys as $key){
    $ids[] = $idsRaw[$key];
}

//$query1 = \common\models\SCSpecialsSlider::find()->select('product_id AS productID');
//$result = \common\models\SCProducts::find()->where(['productID'=>$query1])->andWhere('list_price > Price')->all();
$result = \common\models\SCProducts::find()->where(['<>', 'categoryID', 115433])->andWhere(['in','productID', $ids])->limit(50)->all();

?>

<div class="special-proposal">
    <div class="wrapper">
        <h4>Спецпредложения</h4>
        <a href="<?=\yii\helpers\Url::to(['/shop/actions'])?>">Смотреть все</a>
    </div>
    <div class="special-proposal-slider owl-carousel owl-theme">
        <?php foreach ($result as $s):?>
            <?php

            if($s->in_stock <= 0 || $s->list_price < $s->Price)continue;

            ?>
            <div class="item">
                <div class="item-inner">
                    <div class="img-wrapper">
                        <img src="<?=Yii::$app->imageman->load('/products_pictures/'.$s->picUrl, '250x250', Yii::$app->settings->get('image', 'productSmall'), false, 'products')?>" alt="">
                    </div>
                    <h2 class="title"><?=$s->name_ru?></h2>
                    <?php if($s->list_price > $s->Price):?>
                        <div class="old-price"><?=$s->oldPrice?> руб.</div>
                    <?php endif;?>
                    <div class="new-price"><?=$s->normalPrice?> руб.</div>
                    <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$s->categoryID, 'product'=>($s instanceof \common\models\SCProducts?$s->productID:null)])?>"></a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>



<?php
/*
 * <div class="special-proposal">
    <div class="wrapper">
        <h4>Спецпредложения</h4>
        <a href="">Смотреть все</a>
    </div>
    <div class="special-proposal-slider">
        <?php foreach ($result as $s):?>
            <div class="item"><h4>1</h4></div>
        <?php endforeach;?>
    </div>
</div>
 *
 */