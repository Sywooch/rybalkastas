<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\SummerNote;

/* @var $this yii\web\View */
/* @var $model common\models\SCAuxPages */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="scaux-pages-form">
    <div class="row">
        <div class="col-xs-11">
            <ul class="nav nav-pills">
                <li class="active">
                    <?= Html::a('Основные данные', ['#main'], [
                        'data-toggle' => 'tab',
                    ]) ?>
                </li>
                <li>
                    <?= Html::a('HTML', ['#html'], [
                        'data-toggle' => 'tab',
                    ]) ?>
                </li>
                <li>
                    <?= Html::a('Meta-данные', ['#meta-data'], [
                        'data-toggle' => 'tab',
                    ]) ?>
                </li>
            </ul>
        </div>

        <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group col-xs-1 text-right">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span>', [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'form'  => 'aux_page_form'
                ]) ?>
            </div>
        <?php } ?>
    </div>

    <br>

    <?php $form = ActiveForm::begin([
            'id' => 'aux_page_form'
    ]); ?>

    <div class="tab-content">
        <div id="main" class="tab-pane active fade in">
            <?= $form->field($model, 'aux_page_name_ru')
                ->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'aux_page_slug')
                ->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'aux_page_enabled')
                ->dropDownList(\common\models\SCAuxPages::getStatusList())
                ->label('Статус') ?>
        </div>

        <div id="html" class="tab-pane fade">
            <?= $form->field($model, 'aux_page_text_ru')
                ->widget(SummerNote::className())
                ->label(false) ?>
        </div>

        <div id="meta-data" class="tab-pane fade">
            <?= $form->field($model, 'meta_keywords_ru')
                ->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_description_ru')
                ->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
