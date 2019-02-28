<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Информация о покупателе');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'customer-form',

                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>
                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'city')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SCCities::find()->orderBy('cityName')->all(),'cityID','cityName'),
                    'options' => ['placeholder' => 'Выбрать город'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
                <?= $form->field($model, 'street') ?>
                <?= $form->field($model, 'house') ?>
                <?= $form->field($model, 'zip') ?>

                <div class="form-group">
                    <div >
                        <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary btn-block btn-flat ']) ?><br>
                    </div>
                </div>

                <?php if($_SERVER['REMOTE_ADDR'] == "176.107.242.44"):?>
                    <?=Yii::$app->user->identity->customer->{'1c_id'}?>
                    <a href="<?=\yii\helpers\Url::to(['site/reload-me'])?>" class="btn btn-warning btn-flat btn-block">Перегрузка</a>
                <?php endif;?>

                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
