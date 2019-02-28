<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SCCertificates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sccertificates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'certificateNumber')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'certificateCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'certificateRating')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'certificateUsed')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a href="<?=\yii\helpers\Url::to(['refresh', 'id'=>$model->certificateID])?>" class="btn btn-warning">Сбросить код</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
