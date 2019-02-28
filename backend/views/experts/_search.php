<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SCExpertsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scexperts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'expert_id') ?>

    <?= $form->field($model, 'expert_name') ?>

    <?= $form->field($model, 'expert_last_name') ?>

    <?= $form->field($model, 'mini_description') ?>

    <?= $form->field($model, 'full_text') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'blog_picture') ?>

    <?php // echo $form->field($model, 'shop') ?>

    <?php // echo $form->field($model, 'expert_fullname') ?>

    <?php // echo $form->field($model, '1c_id') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'is_online') ?>

    <?php // echo $form->field($model, 'shop_id') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
