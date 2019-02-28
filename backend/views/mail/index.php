<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;
use yii\helpers\Url;
$this->title = "Рассылка почты";

\yii\bootstrap\BootstrapAsset::register($this);
?>


<?php $form = ActiveForm::begin([
    'id'=>'mailsender',
]); ?>

<?php
$innerMails = [
    'news@mail.rybalkashop.ru'=>'news@mail.rybalkashop.ru',
    'actions@mail.rybalkashop.ru'=>'actions@mail.rybalkashop.ru',
    'mailer@mail.rybalkashop.ru'=>'mailer@mail.rybalkashop.ru',
    'administration@mail.rybalkashop.ru'=>'administration@mail.rybalkashop.ru'
];
$model->test = 1;
?>

<?= $form->field($model, 'from')->dropDownList($innerMails) ?>
<?= $form->field($model, 'subject') ?>
<?= $form->field($model, 'content')->textarea(['rows'=>20]) ?>
<?= $form->field($model, 'test')->checkbox() ?>
<?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

