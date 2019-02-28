<?php

use common\models\SCSlider1;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Облуживание';
?>

<div class="slider-container rev_slider_wrapper" style="height: 1000px;">
    <div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"sliderLayout": "fullscreen", "fullScreenOffsetContainer": "", "fullScreenOffset": "0"}'>
        <ul>
            <li data-transition="fade">
                <div class="rs-background-video-layer"
                     data-forcerewind="on"
                     data-volume="mute"
                     data-videowidth="100%"
                     data-videoheight="100%"
                     data-videomp4="/img/alpvid2.mp4"
                     data-videopreload="preload"
                     data-videoloop="loop"
                     data-forceCover="1"
                     data-aspectratio="16:9"
                     data-autoplay="true"
                     data-autoplayonlyfirsttime="false"
                     data-nextslideatend="true"
                ></div>

                <div class="tp-caption"
                     data-x="center"
                     data-y="center" data-voffset="-95"
                     data-start="500"
                     style="z-index: 5"
                     data-transform_in="x:[-300%];opacity:0;s:500;"><img src="/img/logo.png" alt=""></div>

                <?php if(!Yii::$app->user->isGuest):?>
                    <div class="tp-caption top-label"
                         data-x="center" data-hoffset="0"
                         data-y="center"
                         data-start="100"
                         style="z-index: 5;font-size: 51px;
    color: #fff;"

                         data-transform_in="y:[-300%];opacity:0;s:500;">Здравствуйте, <?=Yii::$app->user->identity->profile->name;?>.</div>
                    <div class="tp-caption top-label"
                         data-x="center" data-hoffset="0"
                         data-y="center" data-voffset="65"
                         data-start="500"
                         style="z-index: 5;font-size: 34px;
    color: #fff;"

                         data-transform_in="x:[300%];opacity:0;s:500;">Магазин находится в режиме обслуживания. Скоро вернемся!</div>
                <?php else:?>
                    <div class="tp-caption top-label"
                         data-x="center" data-hoffset="0"
                         data-y="center"
                         data-start="1000"
                         style="z-index: 5;font-size: 34px;
    color: #fff;"

                         data-transform_in="y:[-300%];opacity:0;s:500;">Магазин находится в режиме обслуживания. Скоро вернемся!</div>

                    <div class="tp-caption top-label"
                         data-x="center" data-hoffset="0"
                         data-y="center" data-voffset="65"
                         data-start="100"
                         style="z-index: 5;font-size: 51px;
    color: #fff;"

                         data-transform_in="y:[-300%];opacity:0;s:500;">
                        <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">
                            Вход для сотрудников
                        </button>
                    </div>
                <?php endif;?>



                <div class="tp-dottedoverlay tp-opacity-overlay"></div>
            </li>
        </ul>
    </div>



</div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                //'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
            ]) ?>




            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Войти</h4>
                </div>
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <?= Html::submitButton(
                        Yii::t('user', 'Sign in'),
                        ['class' => 'btn btn-primary', 'tabindex' => '4']
                    ) ?>
                </div>
            </div><!-- /.modal-content -->


            <?php ActiveForm::end(); ?>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<style>
    .tp-dottedoverlay.tp-opacity-overlay {
        background: #000;
        opacity: 0.7;
    }
</style>
<?php $js = <<< JS
 $('#revolutionSlider').revolution({
    delay:15000,
    startwidth:1170,
    startheight:500,
    hideThumbs:10,
    fullWidth:"off",
    fullScreen:"on",
    fullScreenOffsetContainer: "",
    videoJsPath:"rs-plugin/videojs/"
 });
JS;

$this->registerJs($js);
