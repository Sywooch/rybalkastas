<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SCOrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scorders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'orderID') ?>

    <?= $form->field($model, 'customerID') ?>

    <?= $form->field($model, 'order_time') ?>

    <?= $form->field($model, 'customer_ip') ?>

    <?= $form->field($model, 'shipping_type') ?>

    <?php // echo $form->field($model, 'shipping_module_id') ?>

    <?php // echo $form->field($model, 'payment_type') ?>

    <?php // echo $form->field($model, 'payment_module_id') ?>

    <?php // echo $form->field($model, 'customers_comment') ?>

    <?php // echo $form->field($model, 'statusID') ?>

    <?php // echo $form->field($model, 'shipping_cost') ?>

    <?php // echo $form->field($model, 'order_discount') ?>

    <?php // echo $form->field($model, 'discount_description') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <?php // echo $form->field($model, 'currency_code') ?>

    <?php // echo $form->field($model, 'currency_value') ?>

    <?php // echo $form->field($model, 'customer_firstname') ?>

    <?php // echo $form->field($model, 'customer_lastname') ?>

    <?php // echo $form->field($model, 'customer_email') ?>

    <?php // echo $form->field($model, 'shipping_firstname') ?>

    <?php // echo $form->field($model, 'shipping_lastname') ?>

    <?php // echo $form->field($model, 'shipping_country') ?>

    <?php // echo $form->field($model, 'shipping_state') ?>

    <?php // echo $form->field($model, 'shipping_zip') ?>

    <?php // echo $form->field($model, 'shipping_city') ?>

    <?php // echo $form->field($model, 'shipping_address') ?>

    <?php // echo $form->field($model, 'billing_firstname') ?>

    <?php // echo $form->field($model, 'billing_lastname') ?>

    <?php // echo $form->field($model, 'billing_country') ?>

    <?php // echo $form->field($model, 'billing_state') ?>

    <?php // echo $form->field($model, 'billing_zip') ?>

    <?php // echo $form->field($model, 'billing_city') ?>

    <?php // echo $form->field($model, 'billing_address') ?>

    <?php // echo $form->field($model, 'cc_number') ?>

    <?php // echo $form->field($model, 'cc_holdername') ?>

    <?php // echo $form->field($model, 'cc_expires') ?>

    <?php // echo $form->field($model, 'cc_cvv') ?>

    <?php // echo $form->field($model, 'affiliateID') ?>

    <?php // echo $form->field($model, 'shippingServiceInfo') ?>

    <?php // echo $form->field($model, 'google_order_number') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'id_1c') ?>

    <?php // echo $form->field($model, 'user_phone') ?>

    <?php // echo $form->field($model, 'manager_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
