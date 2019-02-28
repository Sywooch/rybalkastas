<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use kartik\widgets\TouchSpin;
use pendalf89\filemanager\widgets\FileInput;
use zxbodya\yii2\elfinder\ElFinderInput;
use dosamigos\fileupload\FileUploadUI;

/* @var $this  yii\web\View */
/* @var $model common\models\SCProducts */
/* @var $form  ActiveForm */

$this->title = 'Обновить продукт: ' . ' ' . $model->name_ru;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Продукт '.$model->name_ru];

?>

<div class="categories-editproduct">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Изображения товара</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body imagecontainer">
                    <?= $this->render('_productpictures', [
                        'model' => $model
                    ]); ?>
                </div>

                <?= FileUploadUI::widget([
                    'name' => 'pic',
                    'url' => ['categories/uploadimage', 'id' => $model->productID],
                    'options' => ['accept' => 'image/*'],
                    'clientOptions' => [
                        'maxFileSize' => 2000000,
                        'multiple'=>true,
                    ],
                    'clientEvents' => [
                        'fileuploaddone' => 'function(e, data) {
                            console.log(e);
                            console.log(data);
                            $.ajax({
                                url: "'.Url::toRoute('/categories/reloadimages').'",
                                type: "POST",
                                data: {"prd":'.$model->productID.'},
                                success: function (response) {
                                    $(".imagecontainer").html(response);
                                }
                            });
                        }',
                        'fileuploadfail' => 'function(e, data) {
                            console.log(e);
                            console.log(data);
                        }',
                    ],
                ]); ?>
            </div>

            <?php $form = ActiveForm::begin(); ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Тексты</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body" style="display: block;">
                    <?= $form->field($model,'name_ru'); ?>
                    <?= $form->field($model,'description_ru')->textarea(['rows'=>'12']); ?>
                    <?= $form->field($model,'meta_title_ru'); ?>
                    <?= $form->field($model,'meta_keywords_ru'); ?>
                    <?= $form->field($model,'meta_description_ru'); ?>
                </div>
            </div>
            <?php if (Yii::$app->user->can('headField')): ?>
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Наличие (только для администрации)</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $form->field($model, 'in_stock')->widget(TouchSpin::classname(),[
                                    'options' => ['placeholder' => 'Установить количество...'],
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $form->field($model, 'in_stock_provider')->widget(TouchSpin::classname(),[
                                    'options' => ['placeholder' => 'Установить количество на складе поставщиков...'],
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $form->field($model, 'Price'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Картинка приманок</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (!empty($model->color_pic)):?>
                        <div>
                            <label class="control-label" for="scproducts-color_pic">Выбрана картинка</label>
                            <div>
                                <img src="<?= $model->color_pic ?>"/>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?= $form->field($model, 'color_pic')->widget(ElFinderInput::className(), [
                        'connectorRoute' => 'categories/minipicconnector',
                        'settings' => [
                            'lang' => 'ruRU'
                        ]
                    ])?>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Переключатели</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $form->field($model, 'showNew')->widget(SwitchInput::classname(),[
                                'pluginOptions' => [
                                    'onText'  => 'Да',
                                    'offText' => 'Нет'
                                ]
                            ]); ?>
                        </div>

                        <div class="col-md-2">
                            <?php echo $form->field($model, 'is_hidden')->widget(SwitchInput::classname(),[
                                'pluginOptions' => [
                                    'onText'  => 'Да',
                                    'offText' => 'Нет'
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Характеристики продукта</h3>
                    <h6><?= $model->typename; ?></h6>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (!$model->cat_identified): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h4><i class="icon fa fa-ban"></i> Внимание!</h4>
                            Товару не присвоен <b>тип товара</b>! Набор характеристик может быть неверен.<br>
                            Необходимо указать тип товара и заполнить характеристики!
                        </div>
                    <?php endif; ?>

                    <?= $this->render('_options', ['model' => $model]); ?>
                </div>

                <div class="box-footer">
                    <div class="selecttype" style="display: inline-block;">
                        <?php Modal::begin([
                            'header'       => '<h3>Типы товара</h3>',
                            'toggleButton' => [
                                'label' => 'Выбрать тип товара',
                                'class' => 'btn btn-success'
                            ],
                        ]); ?>

                        <div class="cattreemain" data-type="parents">
                            <?= $this->render('_optionsmodal'); ?>
                        </div>

                        <?php Modal::end(); ?>
                    </div>

                    <?php if ($model->cat_identified): ?>
                        <div class="deletetype" style="display: inline-block;">
                            <?= Html::button('Отвязать тип товара', [
                                'class' => 'btn btn-danger'
                            ]); ?>
                        </div>
                    <?php endif; ?>

                    <div class="cancelselecttype" style="display: none">
                        <button type="button" class="btn btn-danger cancelselect">Отменить</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Другие товары в категории</h3>
                </div>

                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <?php foreach($nearProducts as $prd):?>
                            <li class="item">
                                <div class="product-img">
                                    <img style="width: 50px" src="<?= \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$prd->picurl") ?>" alt="<?= $prd->name_ru ?>">
                                </div>
                                <div class="product-info">
                                    <a href="<?= Url::toRoute(['/categories/editproduct', 'id' => $prd->productID]) ?>" class="product-title"><?= $prd->name_ru ?></a>
                                    <span class="product-description">
                                        <a href="<?= Url::toRoute(['/categories/editproduct', 'id' => $prd->productID]) ?>"><i>Редактировать</i></a>
                                    </span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .file-preview-frame {
        display: table;
        margin: 8px;
        height: 160px;
        border: 1px solid #ddd;
        box-shadow: 1px 1px 5px 0 #a2958a;
        padding: 6px;
        float: left;
        text-align: center;
        vertical-align: middle;
        position: relative;
    }
    .file-preview-thumbnails {
        height: 160px;
        vertical-align: middle;
    }

    .removeicon {
        position: absolute;
        display: table-cell;
        width: 40px;
        height: 40px;
        top:0;
    }

    .removeicon button{
        background: none;
        border: none;
        width: 50px;
    }

    .col-md-0{
        float: left;
        width: 0px;
        overflow: hidden;
    }

    .ui-state-highlight {
        display: table;
        margin: 8px;
        height: 160px;
        width: 160px;
        border: 1px solid #dd6200;
        padding: 6px;
        float: left;
        text-align: center;
        vertical-align: middle;
        position: relative;
    }
</style>

<script>
    $(function(){
        $('.removeicon').on('submit', '.imgremover', function(e){
            e.preventDefault();
            $(this).find('.isAjax').attr('disabled', 'disabled');
            $.ajax({
                url: "<?= Url::toRoute('/categories/removeimage'); ?>",
                type: "GET",
                data: $(this).serialize(),
                success: function (response) {
                    $.ajax({
                        url: "<?= Url::toRoute('/categories/reloadimages') ?>",
                        type: "POST",
                        data: {"prd":<?= $model->productID ?>},
                        success: function (response) {
                            $(".imagecontainer").html(response);
                        }
                    });
                }
            });
        });

        $('.setnewoptions').click(function(e){
            $new = $('.hcol');
            $old = $('.ecol');
            $link = $(this);
            $.ajax({
                url: "<?= Url::toRoute('/categories/loadattrs') ?>",
                type: "POST",
                data: {"id":$link.data('catid')},
                success: function (response) {
                    $(".appenixcontainer").html(response);
                    $('.cancelselecttype, .selecttype, .deletetype').toggle();
                    $old.toggleClass('col-md-4', 1000, function(){
                        $new.show().toggleClass('col-md-0 col-md-8', 1000, function(){
                            $old.find('input').attr('disabled', 'disabled');
                        });
                    });
                }
            });
        });

        $('.cancelselect').click(function(e){
            $('.cancelselecttype, .selecttype, .deletetype').toggle();
            $new.toggleClass('col-md-0 col-md-8', 1000, function(){
                $old.toggleClass('col-md-4', 1000, function(){
                    $old.find('input').removeAttr('disabled');
                    $(".appenixcontainer").html("");
                    $new.hide();
                });
            });
        });

        $('.deletetype').click(function () {
            if (confirm("Вы точно хотите сделать это? Все установленные характеристики товара будут удалены!")) {
                $.ajax({
                    url:  "<?= Url::toRoute('/categories/delete-type') ?>",
                    type: "POST",
                    data: {"id" : <?= $model->productID ?>}
                });
            }
        });

        $('.imagecontainer').sortable({
            placeholder: "ui-state-highlight",
            stop: function( ) {
                $(".imagecontainer .file-preview-frame").each(function(){
                    $.ajax({
                        url: "<?= Url::toRoute('/categories/resort-images') ?>",
                        type: "POST",
                        data: {"id" : $(this).data('id'), "priority" : $(this).index()},
                    });
                });
            }
        });
    })
</script>
