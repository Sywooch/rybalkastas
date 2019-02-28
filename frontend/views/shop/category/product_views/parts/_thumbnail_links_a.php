<div class="products_thumbnails row-eq-height" >
    <?php foreach($products as $product):?>
        <div class="thumbview col-md-3 col-sm-6 col-xs-6 product-thumbnail equal-height">
            <?php if($product->list_price > $product->Price):?>
                <div class="ribbon"><span>Акция</span></div>
            <?php endif;?>
            <div class="thumb2cart">
                <?php if($product->canAdd == 1):?>
                <?php
                $modelf = new \frontend\models\AddToCartForm;
                $form = \yii\widgets\ActiveForm::begin([
                    'options'=>['class' => 'thumb-add-to-cart-form', 'data-name'=>$product->name_ru],
                    'action'=>['add-to-cart'],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>
                <?=\yii\helpers\Html::activeHiddenInput($modelf, 'count', ['value'=>'1', 'id'=>'addtocartform-count-'.$product->productID])?>
                <?=\yii\helpers\Html::activeHiddenInput($modelf, 'product', ['value'=>$product->productID, 'id'=>'addtocartform-product-'.$product->productID])?>
                <button type="submit" class="thumbbuybtn btn btn-circle-sm btn-primary"><i class="fa fa-shopping-cart"></i> </button>
                <button type="button" disabled="disabled" style="display: none" class="thumbbuybtn btn btn-circle-sm btn-success"><i class="fa fa-check"></i> </button>

                <?php \yii\widgets\ActiveForm::end(); ?>
                <?php else:?>
                    <button type="button" disabled class="thumbbuybtn btn btn-circle-sm btn-primary"><i class="fa fa-times"></i> </button>
                <?php endif;?>
            </div>
            <a href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>" class="p_pjax">


                <?php if(!empty($product->pictures[0])):?>
                    <img src="<?=Yii::$app->imageman->load('/products_pictures/'.$product->pictures[0]->largest, '200x200', Yii::$app->settings->get('image', 'category'), false, 'categories')?>" alt="good">
                <?php else:?>
                    <img src="<?=Yii::$app->imageman->load('/onDesign.jpg', '200x200', Yii::$app->settings->get('image', 'category'), false, 'common')?>" alt="good">
                <?php endif;?>

                <div class="caption">
                    <div class="prices text-center">
                        <?php if($product->list_price > $product->Price):?>
                            <span class="old"><?=$product->oldPrice?>&nbsp;руб.</span>
                        <?php elseif($product->actualPrice < $product->Price):?>
                            <span class="old"><?=$product->Price?>&nbsp;руб.</span>
                        <?php endif;?>

                        <span class="new"><?=$product->normalActualPrice?>&nbsp;руб.</span>
                    </div>
                    <div class="thumb_attrs">
                        <?php
                        $attrTarget = $product;
                        if(empty($attrTarget->attrs)){
                            $attrTarget = $product->canon;
                        }
                        ?>
                        <?php if($product->canAdd == 0):?>
                            <div class="mini_attr red">
                                <span><?=$product->canAdd?></span>
                            </div>
                        <?php endif;?>

                        <?php if(!empty($attrTarget)):?>
                        <?php foreach($attrTarget->attrs as $attr):?>
                            <?php if(empty($attr->option_value_ru))continue;?>
                            <div class="mini_attr">
                                <span><?=$attr->optionName?>:</span><span> <?=$attr->option_value_ru?></span>
                            </div>
                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <?php if($product->canAdd == 0):?>
                        <p class="not_in_stock"><?=$product->canAdd?></p>
                    <?php endif;?>
                    <h2><?=$product->name_ru?></h2>
                </div>
            </a>
            <div class="clearfix"></div>
        </div>

    <?php endforeach;?>
</div>