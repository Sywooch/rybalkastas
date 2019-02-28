<?php
use yii\helpers\Url;

$cart = Yii::$app->cart;
?>

    <a href="#" class="basket" aria-hidden="true" data-placement="bottom" data-popover-content="#basket_contents"
       data-trigger="click" data-toggle="popover" href="#" tabindex="0">
        <div class="basket_preview">
            <i class="fa fa-shopping-cart"></i>&nbsp;Моя корзина <span id="cart-sum">&nbsp;<?= number_format($cart->getCost(),2) ?> руб.</span>
        </div>

    </a>

    <div class="hidden" id="basket_contents">
        <div class="popover-heading">
            Корзина
        </div>
        <?php $elements = Yii::$app->cart->elements; ?>
        <div class="cart_informer popover-body">
            <?php if (!empty($elements)): ?>
            <div class="cart_table">


                    <table border="0" style="width:100%">

                        <?php foreach ($elements as $p): ?>
                            <?php
                            //$product = \common\models\SCProducts::findOne($p->item_id);
                            $product = Yii::$app->cache->getOrSet('cart_product_'.$p->item_id, function () use ($p) {
                                return \common\models\SCProducts::findOne($p->item_id);
                            });
                            ?>
                            <?php if(empty($product))continue;?>
                            <tr>
                                <td style="width: 20%"><img
                                        src="<?=Yii::$app->imageman->load('/products_pictures/'.$product->picture, '250x250', Yii::$app->settings->get('image', 'productSmall'), false, 'products')?>"/>
                                </td>
                                <td style="min-width: 200px">
                                    <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$product->categoryID, 'product'=>$product->productID])?>">
                                        <?= $product->name_ru ?>
                                    </a>
                                    <br/>
                                    <?= $p->count; ?> x <?= $p->price; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </table>

            </div>
            <div>
                <a href="<?=Url::to(['/cart/index'])?>" class="btn btn-primary btn-block">Перейти в корзину</a>
            </div>
            <?php else:?>
            <div class="text-center">Корзина пуста!</div>
            <?php endif;?>
        </div>
    </div>

