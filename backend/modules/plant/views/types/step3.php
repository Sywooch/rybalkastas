<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;
$this->title = "Агрегатные операции";
?>
<div class="plant-default-index">
    <h1>Типы товаров <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Проверьте данные для установки типа "<?=$cat->category_name_ru?>"</h3><br>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 36%"></div>
                </div>

            </div><!-- /.box-header -->
            <div class="box-body">
                <ul>
                    <li>Найдено <?=count($products);?> товаров:
                        <ul>
                            <?php foreach($products as $p):?>
                            <li><?=$p->name_ru?></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <li>Товарам уже присвоено <?=count($attrs);?> атрибутов:
                        <ul>
                            <?php foreach($attrs as $a):?>
                                <li><?=$a->optionName?></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <p>...</p>
                    <li>Будет утановлена категория "<b><?=$cat->category_name_ru?>"</b></li>
                    <li>В выбранной категории <?=count($cat->options)?> атрибутов
                        <ul>
                            <?php foreach($cat->options as $a):?>
                                <li><?=$a->name_ru?></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                </ul>

            </div><!-- /.box-body -->
            <?php $form = ActiveForm::begin(['action'=>['step4']]); ?>
            <input type="hidden" name="attrCat" value="<?=$cat->categoryID;?>"/>
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



