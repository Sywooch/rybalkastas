<?php $elements = Yii::$app->cart->elements; ?>
<?php $delayedDelivery = 0;?>
<?php foreach ($elements as $p): ?>
    <?php $product = \common\models\SCProducts::findOne($p->item_id);?>
    <?php if(empty($product))continue;?>
    <?php if(!empty($product->getStockStringByCartCount($p->count)))$delayedDelivery = 1;?>
<?php endforeach; ?>
<?php if($delayedDelivery == 1):?>
<strong class="text-red">В заказе присутствуют товары, находящиеся на удаленном складе. Формирование заказа займет от 1 до 7 РАБОЧИХ дней.</strong>
<?php endif;?>