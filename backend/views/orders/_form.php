<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SCOrders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scorders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customerID')->textInput() ?>

    <?= $form->field($model, 'order_time')->textInput() ?>

    <?= $form->field($model, 'customer_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_module_id')->textInput() ?>

    <?= $form->field($model, 'payment_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_module_id')->textInput() ?>

    <?= $form->field($model, 'customers_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'statusID')->textInput() ?>

    <?= $form->field($model, 'shipping_cost')->textInput() ?>

    <?= $form->field($model, 'order_discount')->textInput() ?>

    <?= $form->field($model, 'discount_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_value')->textInput() ?>

    <?= $form->field($model, 'customer_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'billing_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cc_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_holdername')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_expires')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_cvv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'affiliateID')->textInput() ?>

    <?= $form->field($model, 'shippingServiceInfo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'google_order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->dropDownList([ 'storefront' => 'Storefront', 'widgets' => 'Widgets', 'backend' => 'Backend', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'id_1c')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
