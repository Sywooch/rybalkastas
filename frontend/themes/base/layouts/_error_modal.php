<div class="text-right" style="margin-top: 10px">
    <button type="button" style="width: 164px" class="btn btn-danger btn-xs" id="errorModalButton" data-toggle="modal" data-target="#errorModal">
        Нашли ошибку?
    </button>
</div>

<!-- Modal -->

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php
            use yii\helpers\Html;
            use yii\widgets\ActiveForm;



            $form = ActiveForm::begin([
                'action'=>['/site/send-error'],
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="text-center">Сообщение об ошибке</h2>
            </div>
            <div class="modal-body text-left">




                <?php $model = new \frontend\models\ErrorForm();?>

                <?= $form->field($model, 'text')->textarea(); ?>

                <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::className(), [
                    'captchaAction' => 'site/captcha'
                ]) ?>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary', 'tabindex' => '4']
                ) ?>

            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

