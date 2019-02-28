<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;


$this->title = "Сетка";

backend\assets\GridsterAsset::register($this);
?>
<div class="plant-default-index">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Сетка <small>Контент главной страницы</small></h3>
            </div><!-- /.box-header -->
            <div class="box-body" id="actions">
                <?php
                Modal::begin([
                    'header' => '<h2>Добавить изображение</h2>',
                    'toggleButton' => ['label' => 'Добавить изображение', 'class'=>'btn btn-success'],
                    'id' => 'insert-modal',
                ]);?>

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/content/front-grid/insert']),
                    'options' => ['enctype'=>'multipart/form-data'],
                    'id' => 'mainpage-insert',
                ]); ?>

                <?= $form->field($newgrid, 'picture')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                ]);?>

                <?= $form->field($newgrid, 'url') ?>

                <div class="form-group">
                    <?= Html::submitButton($newgrid->isNewRecord ? 'Создать' : 'Обновить', ['class' => $newgrid->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <?php
                Modal::end();
                ?>
            </div>
            <div class="box-body" id="gridcontainer">
                <?=$this->render('_grid',['model'=>$model]);?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>

</div>

<script>
    $(function() {

        $('#mainpage-insert').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            e.stopPropagation();
            var options = {
                success:    function(responseText) {
                    $('#gridcontainer').html(responseText);
                    $('#insert-modal').modal('hide');
                    $('#mainpage-insert').reset();
                }
            };
            $(this).ajaxSubmit(options);

            // !!! Important !!!
            // always return false to prevent standard browser submit and page navigation
            return false;
        });
    });
</script>


