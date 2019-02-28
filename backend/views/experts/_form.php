<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SCExperts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scexperts-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'expert_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expert_last_name')->textInput(['maxlength' => true]) ?>

    <?= froala\froalaeditor\FroalaEditorWidget::widget([
        'model' => $model,
        'attribute' => 'mini_description',
        'options'=>[// html attributes
            'id'=>'content_1'
        ],
        'clientOptions'=>[
            'toolbarInline'=> false,
            'theme' =>'royal',//optional: dark, red, gray, royal
            'language'=>'ru', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
            'toolbarButtons' => ['undo', 'redo','|','fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', '|', 'html', 'paragraphFormat', 'insertImage', 'code'],
            'imageUploadParam'=> 'file',
            'imageUploadURL'=> \yii\helpers\Url::to(['pages/upload/'])
        ],
    ]); ?>

    <?= froala\froalaeditor\FroalaEditorWidget::widget([
        'model' => $model,
        'attribute' => 'full_text',
        'options'=>[// html attributes
            'id'=>'content_2'
        ],
        'clientOptions'=>[
            'toolbarInline'=> false,
            'theme' =>'royal',//optional: dark, red, gray, royal
            'language'=>'ru', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
            'toolbarButtons' => ['undo', 'redo','|','fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', '|', 'html', 'paragraphFormat', 'insertImage', 'code'],
            'imageUploadParam'=> 'file',
            'imageUploadURL'=> \yii\helpers\Url::to(['pages/upload/'])
        ],
    ]); ?>

    <?= $form->field($model, 'picture')->widget(\karpoff\icrop\CropImageUpload::className()) ?>


    <?= $form->field($model, 'shop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
