<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SCProductOptionsCategoryes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scproduct-options-categoryes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_name_ru')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
