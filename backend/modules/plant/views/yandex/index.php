<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = "Агрегатные операции";
?>
<div class="plant-default-index">
    <h1>Товары для Yandex Маркет <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-12">
        <a href="<?=\yii\helpers\Url::to(['/plant/yandex/load'])?>" class="btn bg-maroon btn-flat btn-block">Добавить товары в список</a>

        <div class="box box-solid">
            <?php $form = ActiveForm::begin()?>
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Текущие товары на выгрузку</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th><input id="checkall" type="checkbox"></th>
                        <th>Код</th>
                        <th>Название</th>
                    </tr>
                <?php foreach($model as $m):?>

                        <tr>
                            <td><input type="checkbox" name="CheckProduct[<?=$m->productID;?>]" value="1"></td>
                            <td><?=$m->product_code;?></td>
                            <td class="product_name"><?=$m->name_ru;?></td>
                        </tr>


                <?php endforeach;?>
                    </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <button type="submit" class="btn bg-purple btn-flat margin pull-right">Отменить выгрузку</button>
            </div>
            <?php ActiveForm::end()?>
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>