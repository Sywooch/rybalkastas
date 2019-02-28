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
                <h3 class="box-title">Выберите тип товара</h3>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 0%"></div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                    <?php foreach($model as $m):?>
                        <?php $form = ActiveForm::begin(['action'=>['step2']]); ?>
                        <input type="hidden" name="attrCat" value="<?=$m->categoryID;?>" />
                        <?= Html::submitButton(Yii::t('app', $m->category_name_ru), ['class' => 'btn btn-block btn-primary']) ?>
                        <?php ActiveForm::end(); ?>
                    <?php endforeach;?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>
