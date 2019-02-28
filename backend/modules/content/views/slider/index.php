<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use bupy7\cropbox\Cropbox;
use karpoff\icrop\CropImageUpload;

$this->title = "Слайдер";
backend\assets\JuiAsset::register($this);

?>
<div class="plant-default-index">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Добавить слайд</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php
                Modal::begin([
                    'header' => '<h2>Добавить изображение</h2>',
                    'toggleButton' => ['label' => 'Добавить изображение', 'class'=>'btn btn-success'],
                    'id' => 'insert-modal',
                ]);?>

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/content/slider/insert']),
                    'options' => ['enctype'=>'multipart/form-data'],
                    'id' => 'mainpage-insert',

                ]); ?>



                <?= $form->field($newslide, 'image')->widget(CropImageUpload::className()) ?>

                <?= $form->field($newslide, 'text') ?>

                <?= $form->field($newslide, 'url') ?>

                <div class="form-group">
                    <?= Html::submitButton($newslide->isNewRecord ? 'Создать' : 'Обновить', ['class' => $newslide->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <?php
                Modal::end();
                ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Список слайдов</h3>
            </div><!-- /.box-header -->
            <div class="box-body" id="container">
                <?=$this->render("_slides", ['model'=>$model]);?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="clearfix"></div>
</div>

<script>
    $(function(){
        $('.slidelabel').draggable({
            containment: "parent"

        });

        $('#container').sortable({
            handle: '.sort',
            axis: "y",
            stop: function( ) {
                $('#container form').each(function(){
                    index = $(this).index();
                    id = $(this).data('id');
                    $.post( "<?=Url::toRoute(['/content/slider/sort'])?>", { id: id, sort: index });
                })
            }
        });

    })
</script>
