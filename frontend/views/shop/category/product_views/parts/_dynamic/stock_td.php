<?php

/* @var $product \common\models\SCProducts */

$product = \common\models\SCProducts::findOne($product)

?>

<?php if ($product->onlyRetail): ?>
    <span data-toggle="tooltip" data-placement="top" title="Данный товар можно купить только в магазинах нашей розничной сети">
        Только в магазинах
    </span>
<?php elseif ($product->canAdd == 1): ?>
    <?php $modelf = new \frontend\models\AddToCartForm;

    $form = \yii\widgets\ActiveForm::begin([
        'options' => [
            'class' => 'micro-add-to-cart-form',
            'data-name' => $product->name_ru,
            'id' => 'add-to-cart-form-' . $product->productID
        ],
        'action' => ['add-to-cart'],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

    <?= \yii\helpers\Html::activeHiddenInput($modelf, 'count', [
        'value' => '1',
        'id'    => 'addtocartform-count-' . $product->productID
    ]) ?>
    <?= \yii\helpers\Html::activeHiddenInput($modelf, 'product', [
        'value' => $product->productID,
        'id'    => 'addtocartform-product-' . $product->productID
    ]) ?>

    <input type="submit" value="В&nbsp;корзину" class="tobasket buybtn"/>
    <button class="tobasket buybtn" style="display: none" disabled="disabled" type="button">
        <i class="fa fa-spinner fa-spin fa-fw"></i>
    </button>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <span class="instock">есть в наличии</span>
<?php else: ?>
    <?php if ($product->in_stock > 0): ?>
        <span class="tobasket">В&nbsp;корзину</span>
        <span class="instock">есть в наличии</span>
    <?php else: ?>
        <span class="text-red text-bold">Нет в наличии</span><br/>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if ($product->userIsSubscribed): ?>
                <span class="text-primery">Вы ожидаете поступление</span>
            <?php else: ?>
                <span class="text-primery towaiting" data-id="<?= $product->productID ?>">Сообщить о поступлении</span>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
