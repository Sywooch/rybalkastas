<?php if ($model->list_price > $model->Price): ?>
    <div class="old"><?= $model->oldPrice ?> руб.</div>
<?php endif; ?>
<?php if($model->Price > $model->actualPrice):?>
    <div class="old"><?=number_format($model->Price,2)?> руб.</div>
    <div class="actual">
        <?php if(Yii::$app->user->isGuest):?>
            <span class="note"><abbr data-toggle="tooltip" data-placement="top" title="Скидка <?=$model->maxDiscount?>%">Специальная цена на позицию</abbr>:</span>
        <?php else:?>
            <span class="note"><abbr data-toggle="tooltip" data-placement="top" title="Скидка составляет <?=$model->maxDiscount?>%">Ваша клубная цена</abbr>:</span>
        <?php endif;?>
        <span class="price"><?= $model->normalActualPrice ?> руб</span>
    </div>
<?php else:?>
<div itemprop="price" content="<?=$model->Price?>" class="new <?php if($model->Price > $model->actualPrice):?>through<?php endif;?>"><?= $model->normalPrice ?> <span itemprop="priceCurrency" content="RUR">руб.</span></div>
<?php endif;?>




