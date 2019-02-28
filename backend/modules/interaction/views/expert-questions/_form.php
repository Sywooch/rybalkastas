<?php
use yii\widgets\ActiveForm;
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 28.02.2017
 * Time: 13:05
 */

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data'],
    'id' => 'mainpage-insert',
]); ?>

<?= $form->field($model, 'expert_name') ?>
<?= $form->field($model, 'expert_last_name') ?>

<?= $form->field($model, 'picture')->widget(\karpoff\icrop\CropImageUpload::className()) ?>

<?= $form->field($model, 'mini_description')->textarea() ?>
<?= $form->field($model, 'full_text')->textarea() ?>

<?= $form->field($model, 'shop') ?>
<?= $form->field($model, 'email') ?>

<div class="form-group">
    <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>
</div>


<?php ActiveForm::end(); ?>

