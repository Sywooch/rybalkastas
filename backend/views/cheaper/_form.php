<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SCFoundCheaper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scfound-cheaper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customerID')->textInput() ?>

    <?= $form->field($model, 'productID')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
