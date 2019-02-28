<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = "Бренды";
?>
<div class="plant-default-index">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Список брендов</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php foreach($model as $m):?>
                    <div class="well well-sm">
                        <?=$m->name;?>
                    </div>
                <?php endforeach;?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Создать бренд</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($newbrand, 'name') ?>


                <div class="form-group">
                    <?= Html::submitButton($newbrand->isNewRecord ? 'Создать' : 'Обновить', ['class' => $newbrand->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>
