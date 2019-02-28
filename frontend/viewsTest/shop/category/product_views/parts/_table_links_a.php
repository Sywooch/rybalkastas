<?php
$emptyOptions = [];



?>


<div class="products_table">
    <div class="table_head">
        <div class="tdelement"><span title="sort this column"><b>Наименование товара</b></span></div>
        <?php foreach($alloptions as $ao):?>
            <div class="tdelement hidden-sm hidden-xs"><?=$ao?></div>
        <?php endforeach;?>
        <div class="tdelement" id="pricehead"><span title="sort this column"><b>Цена</b></span></div>
        <div class="tdxelement"><b>Купить</b></div>
    </div>
    <?php foreach($products as $product):?>
    <div class="table_body">
        <a class="table_product_name p_pjax" href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>"><span><b><?=$product->name_ru?></b></span></a>
        <?php foreach($alloptions as $k=>$ao):?>
            <a class="p_pjax  hidden-sm hidden-xs" href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>">
                <?=@\common\models\SCProductOptionsValues::find()->where("productID = $product->productID AND optionID = $k")->one()->option_value_ru;?>
            </a>
        <?php endforeach;?>
        <a class="p_pjax" href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>">
            <?php if($product->list_price > $product->Price):?>
                <span class="old"><?=$product->oldPrice?>&nbsp;руб.</span>
            <?php endif;?>
            <span class="new"><?=$product->normalPrice?>&nbsp;руб.</span>
        </a>
        <a href="#">
            <?php if($product->canAdd == 1):?>
                <?php
                $modelf = new \frontend\models\AddToCartForm;
                $form = \yii\widgets\ActiveForm::begin([
                    'options'=>['class' => 'micro-add-to-cart-form', 'data-name'=>$product->name_ru],
                    'action'=>['add-to-cart'],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,

                ]) ?>
                <?=\yii\helpers\Html::activeHiddenInput($modelf, 'count', ['value'=>'1'])?>
                <?=\yii\helpers\Html::activeHiddenInput($modelf, 'product', ['value'=>$product->productID])?>
                <input type="submit" value="В&nbsp;корзину" class="tobasket buybtn" />
                <button class="tobasket buybtn" style="display: none" disabled="disabled" type="button"><i class="fa fa-spinner fa-spin fa-fw"></i></button>

                <?php \yii\widgets\ActiveForm::end(); ?>
                <span class="instock">есть в наличии</span>
            <?php else:?>
                <span class="text-red text-bold"><?=$product->canAdd?></span>
            <?php endif;?>
        </a>
    </div>
    <?php endforeach;?>
</div>