<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;
$this->title = "Агрегатные операции";
?>
<div class="plant-default-index">
    <h1>Товары для Yandex Маркет <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
            </div><!-- /.box-header -->
            <div class="box-body">
                <ul>
                    <li>Найдено <?=count($products);?> товаров, которые будут выгружены в Yandex маркет:
                        <ul>
                            <?php foreach($products as $p):?>
                                <li><?=$p->name_ru?></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.box-body -->
            <?php $form = ActiveForm::begin(['action'=>['set']]); ?>
            <?php foreach($products as $p):?>
                <input type="hidden" name="chunk" value="1"/>
                <input type="hidden" name="products[]" value="<?=$p->productID?>"/>
            <?php endforeach;?>
            <?= Html::submitButton("Подтвердить", ['class' => 'btn btn-block btn-success pull-right']) ?>
            <?php ActiveForm::end(); ?>
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>



