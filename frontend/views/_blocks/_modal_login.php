<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$form = ActiveForm::begin([
    'action'=>['/user/security/login'],
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
    'validateOnType' => false,
    'validateOnChange' => false,
]) ?>



    <?php $model = \Yii::createObject(\dektrium\user\models\LoginForm::className());?>

            <?= $form->field($model, 'login',
                ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
            );
            ?>

            <?= $form->field(
                $model,
                'password',
                ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                ->passwordInput()
            ?>

            <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <?= Html::submitButton(
            Yii::t('user', 'Sign in'),
            ['class' => 'btn btn-primary', 'tabindex' => '4']
        ) ?>
        <div class="clearfix"></div>
        <hr/>
        <div class="text-center">
            <a href="<?=\yii\helpers\Url::to(['/user/recovery/request'])?>">Забыли пароль?</a> | <a href="<?=\yii\helpers\Url::to(['/user/registration/register'])?>">Создать учетную запись</a>
        </div>
    </div>


<?php ActiveForm::end(); ?>