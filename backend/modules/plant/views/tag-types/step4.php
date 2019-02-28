<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = "Агрегатные операции";
?>
<div class="plant-default-index">
    <h1>Типы товаров <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Операция завершена</h3>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">

                <ul>
                    <?php foreach($log as $l):?>
                        <li><?=$l?></li>
                    <?php endforeach;?>
                </ul>
                <br>
                Операция успешно завершена!
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>
