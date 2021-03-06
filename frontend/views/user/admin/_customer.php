<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-9',
        ],
    ],
]); ?>

<?= $form->field($customer, 'first_name') ?>
<?= $form->field($customer, 'last_name') ?>
<?= $form->field($customer, 'phone') ?>
<?= $form->field($customer, 'city')->widget(Select2::classname(), [
    'data' => \yii\helpers\ArrayHelper::map(\common\models\SCCities::find()->orderBy('cityName')->all(),'cityID','cityName'),
    'options' => ['placeholder' => 'Выбрать город'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
<?= $form->field($customer, 'street') ?>
<?= $form->field($customer, 'house') ?>
<?= $form->field($customer, 'zip') ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
