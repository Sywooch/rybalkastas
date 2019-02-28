<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = "Агрегатные операции";
?>
<div class="plant-default-index">
    <h1>Очистка неиспользуемых значений атрибутов <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Очистка</h3>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 0%"></div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <small>
                    Данный модуль не требует никаких условий для его выполнения. В процессе работы с сайтом, могут возникать лишние (пустые) значения атрибутов, устанавливаемых через старую админку.
                    <br>
                    Для того, чтобы избавить базу данных от лишней нагрузки, необходимо иногда заходить на эту страницу и очищать все пустые значения.
                </small>
                <div>
                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" name="clear" value="1" />
                    <?= Html::submitButton("Очистить лишние атрибуты", ['class' => 'btn btn-block btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>
