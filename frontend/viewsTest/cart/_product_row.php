<tr>
    <td width="90">
        <img src="<?=Yii::$app->imageman->load('/products_pictures/'.$product->picture, '250x250', Yii::$app->settings->get('image', 'productSmall'), false, 'products')?>"/>
    </td>
    <td width="40%" class="desc">
        <h2 class="title">
            <a href="<?=\yii\helpers\Url::to(['shop/category', 'id'=>$product->categoryID, 'product'=>$product->productID])?>" class="text-navy">
                <?= $product->name_ru ?>
            </a>
        </h2>
        <p class="small">
            Арт. <?= $product->product_code ?> <?php if($product->in_stock <= 0):?><b>(Нет в наличии)</b><?php endif;?>
        </p>
        <?php if(!empty($product->getStockStringByCartCount($p->count))):?>
        <p class="small text-red">
            <?=$product->getStockStringByCartCount($p->count)?>
        </p>
        <?php endif;?>
        <br/>
        <div class="m-t-sm">
            <?php if(!Yii::$app->user->isGuest):?>
            <a href="<?=\yii\helpers\Url::to(['add-later-cart', 'item'=>$p->id])?>" class="text-muted addLater"><i class="fa fa-clock-o"></i> Отложить</a>
            |
            <?php endif;?>
            <a href="<?=\yii\helpers\Url::to(['item-edit', 'action'=>'delete', 'item'=>$p->id])?>" class="text-muted item-manipulation removeItem"><i class="fa fa-trash"></i> Удалить</a>
        </div>
    </td>
    <td>
        <?= $p->price; ?> руб.
    </td>
    <td width="170">

        <div class="input-group">
            <span class="input-group-btn">
                <?php if($p->count == 1):?>
                    <a href="#" class="btn btn-default disabled item-manipulation"><i class="fa fa-minus"></i> </a>
                <?php else:?>
                    <a href="<?=\yii\helpers\Url::to(['item-edit', 'action'=>'decrement', 'item'=>$p->id])?>" class="btn btn-default item-manipulation"><i class="fa fa-minus"></i></a>
                <?php endif;?>
              </span>
            <input type="text" class="form-control text-center" value="<?= $p->count; ?>">
              <span class="input-group-btn">
                <?php if($p->count < $product->in_stock):?>
                    <a href="<?=\yii\helpers\Url::to(['item-edit', 'action'=>'increment', 'item'=>$p->id])?>" class="btn btn-default item-manipulation"><i class="fa fa-plus"></i> </a>
                <?php else:?>
                    <a href="#" class="btn btn-default disabled item-manipulation"><i class="fa fa-plus"></i> </a>
                <?php endif;?>
              </span>
        </div>

    </td>
    <td>
        <b>
            <?= number_format($p->price * $p->count,2); ?>&nbsp;руб.
        </b>
    </td>
</tr>