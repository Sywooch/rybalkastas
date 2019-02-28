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
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username')->hint('Используется для входа на сайт') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <hr/>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'first_name') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name') ?>
                    </div>
                </div>

                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'city')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SCCities::find()->orderBy('cityName')->all(),'cityID','cityName'),
                    'options' => ['placeholder' => 'Выбрать город'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
                <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'street') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'house') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'zip') ?>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'accept_policy', ['template' => "<div class=\"\">\n{input}\nЯ ознакомился с <a href='".\yii\helpers\Url::to(['/page/index', 'slug'=>'public_offer'])."'>договором публичной оферты</a> и <a href='".\yii\helpers\Url::to(['/page/index', 'slug'=>'privacy_policy'])."'>политикой конфиденциальности</a>\n{error}\n{hint}\n</div>"])->checkbox(['uncheck'=>null]);?>
                    </div>
                </div>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-primary btn-flat btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
