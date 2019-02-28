<?php $emptyOptions = []; ?>

<div class="products_table">
    <div class="table_head">
        <div class="tdelement">
            <span title="sort this column"><b>Наименование товара</b></span>
        </div>

        <?php foreach($alloptions as $ao):?>
            <div class="tdelement hidden-sm hidden-xs"><?=$ao?></div>
        <?php endforeach;?>

        <div class="tdelement" id="pricehead">
            <span title="sort this column"><b>Цена</b></span>
        </div>
        <div class="tdxelement"><b>Купить</b></div>
    </div>
    <?php foreach($products as $product):?>
        <div class="table_body">
            <a class="table_product_name p_pjax" href="<?=\yii\helpers\Url::to(['category', 'product' => $product->productID, 'id' => $id])?>">
                <span><b><?= $product->name_ru ?></b></span>
            </a>

            <?php foreach($alloptions as $k=>$ao): ?>
                <a class="p_pjax  hidden-sm hidden-xs" href="<?= \yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id]) ?>">
                    <?= @\common\models\SCProductOptionsValues::find()->where("productID = $product->productID AND optionID = $k")->one()->option_value_ru; ?>
                </a>
            <?php endforeach;?>

            <a class="p_pjax" href="<?=\yii\helpers\Url::to(['category', 'product' => $product->productID, 'id' => $id]) ?>">
                <?php if ($product->list_price > $product->Price): ?>
                    <span class="old"><?= $product->oldPrice ?>&nbsp;руб.</span>
                <?php elseif ($product->actualPrice < $product->Price): ?>
                    <span class="old"><?= $product->Price ?>&nbsp;руб.</span>
                <?php endif;?>

                <span class="new"><?= $product->normalActualPrice ?>&nbsp;руб.</span>
            </a>

            <a href="#">
                <?= $this->renderDynamic(
                    "\$product = unserialize('" . serialize($product->productID) . "');
                    return Yii::\$app->view->render('//shop/category/product_views/parts/_dynamic/stock_td', ['product' => \$product]);"
                ) ?>
            </a>
        </div>
    <?php endforeach;?>
</div>
