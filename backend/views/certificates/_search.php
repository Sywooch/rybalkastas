<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SCCertificatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sccertificates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'certificateID') ?>

    <?= $form->field($model, 'certificateNumber') ?>

    <?= $form->field($model, 'certificateCode') ?>

    <?= $form->field($model, 'certificateRating') ?>

    <?= $form->field($model, 'certificateUsed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
