<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;
use yii\helpers\Url;
$this->title = "Рассылка уведомлений";
?>


<?php $form = ActiveForm::begin([
    'id'=>'mailsender',
]); ?>
<?= $form->field($model, 'mini_text') ?>
<?= $form->field($model, 'full_text')->widget(Widget::className(), [
    'settings' => [
        'imageUpload' => Url::to(['/mail/image-upload']),
        'lang' => 'ru',
        'minHeight' => 200,
        'plugins' => [
            'clips',
            'fullscreen'
        ]
    ]
]); ?>

<?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

