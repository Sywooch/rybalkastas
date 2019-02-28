<?php

use yii\bootstrap\Modal;

$cart = Yii::$app->cart;
$elements = Yii::$app->cart->elements;
$minPriceInt = Yii::$app->settings->get('cart', 'minprice')-(empty(\Yii::$app->session->get('certificateID'))?0:Yii::$app->settings->get('cart', 'minprice'));



?>
<div class="ibox">
    <div class="ibox-title">
        <span class="pull-right">(<strong class="cart_count"><?= $cart->count ?></strong>) товаров</span>
        <h5>Товары в вашей корзине</h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table shoping-cart-table">

                <tbody>
                <?php $delayedDelivery = 0;?>
                <?php foreach ($elements as $p): ?>
                    <?php $product = \common\models\SCProducts::findOne($p->item_id);?>
                    <?php if(empty($product))continue;?>
                    <?php if(!empty($product->getStockStringByCartCount($p->count)))$delayedDelivery = 1;?>
                    <?= $this->render('_product_row', ['p' => $p, 'product'=>$product]); ?>
                <?php endforeach; ?>
                </tbody>
                <tbody>
                <?php if($delayedDelivery == 1):?>
                <tr>
                    <td id="cart_msg" colspan="5">
                        <?=$this->render('_cart_msg')?>
                    </td>
                </tr>
                <?php endif;?>
                <tr>
                    <td colspan="1" class="text-right"></td>
                    <td colspan="4" class="certificate">
                        <?php $certificate = Yii::$app->session->get('certificateID')?>
                        <?php if(empty($certificate)):?>
                            <?php

                            Modal::begin([
                                'header' => '<h2>Проверка подарочного сертификата</h2>',
                                'toggleButton' => ['label' => 'Применить подарочный сертификат', 'class'=>'btn btn-primary btn-flat'],
                            ]);

                            ?>


                            <?php $form = \kartik\widgets\ActiveForm::begin(['id'=>'cert_form', 'action'=>['apply-certificate'],'enableAjaxValidation' => true]); ?>
                            <?=$form->field($certForm,'number')->textInput(['placeholder'=>'Номер подарочного сертификата'])->label(false);?>
                            <?=$form->field($certForm,'code')->textInput(['placeholder'=>'Защитный код'])->label(false);?>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary">Применить</button>
                            </div>


                            <?php \kartik\widgets\ActiveForm::end(); ?>



                            <?php

                            Modal::end();

                            ?>

                        <?php else:?>

                            <?php $certificate = \common\models\SCCertificates::findOne($certificate);?>

                            <span class="text-success">Применен подарочный сертификат на сумму <b><?=number_format($certificate->certificateRating,2) ?> руб.</b></span>


                        <?php endif;?>


                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div class="minpricemsg"><?php if($cart->getCost() < $minPriceInt)echo Yii::$app->settings->get('cart', 'minpricemsg');?></div></td>
                    <td colspan="2">Сумма корзины:</td>
                    <td><b class="cart-sum-accept"><?= number_format($cart->getCost(), 2) ?>&nbsp;руб.</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    $js = <<< JS
$('#cert_form').submit(function(){
    
});
JS;

?>
