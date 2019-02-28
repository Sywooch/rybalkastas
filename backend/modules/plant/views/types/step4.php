<?php
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;
$this->title = "Агрегатные операции";
backend\assets\LinesAsset::register($this);
?>
<div class="plant-default-index">
    <h1>Типы товаров <small>Агрегатный модуль</small></h1>
    <?= $this->render("_header");?>
    <div class="col-md-6 col-md-offset-3">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Проведите связи между старыми и новыми атрибутами</h3><br>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 76%"></div>
                </div>

            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-4">
                    <h4>Установленные атрибуты</h4>
                    <hr>
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <h4>Новые атрибуты</h4>
                    <hr>
                </div>
                <div id="linesContainer">
                    <?php $i1 = 45;?>
                    <?php foreach($attrs as $a):?>
                        <button type="button" data-id="<?=$a->optionID?>" data-name="<?=$a->optionName?>" class="btn bg-maroon btn-block btn-flat margin left" style="top: <?=$i1;?>px"><?=$a->optionName?></button>
                        <?php $i1 = $i1+45;?>
                    <?php endforeach;?>

                    <?php $i2 = 45;?>
                    <?php foreach($cat->options as $a):?>
                        <button type="button" data-id="<?=$a->optionID?>" data-name="<?=$a->name_ru?>" class="btn bg-purple btn-block btn-flat margin right" disabled="disabled" style="top: <?=$i2;?>px"><?=$a->name_ru?></button>
                        <?php $i2 = $i2+45;?>
                    <?php endforeach;?>
                    <div class="clearfix"></div>
                </div>
                <div id="order">
                    <h3>Отчет</h3>
                    <ul>

                    </ul>
                </div>
            </div><!-- /.box-body -->
            <?php $form = ActiveForm::begin(['action'=>['finish']]); ?>
            <div id="inputs">

            </div>
            <div>
                <button type="button" class="btn btn-block btn-danger cancelbutton hide">Отменить все</button>
            </div>
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

<?php $script = <<< JS
    var mySVG = $('#linesContainer').connect();
    var connectOldToNew = false;
    var connectNewToOld = false;

    $('.btn.left').click(function(){

        if(connectOldToNew == false){
            $('.btn.right').removeAttr('disabled');
            connectOldToNew = true;
            invokeOldToNew($(this));
        } else {
            connectOldToNew = false;
            endOldToNew();
        }


    });

    $('.btn.right').click(function(){

        if(connectNewToOld == false){
            if(connectOldToNew == true){
                connectOldToNew = false;
                mySVG.drawLine({
                    left_node:'.btn.left.flashing',
                    right_node:$(this),
                    horizantal_gap:10,
                    error:true,
                    width:1
                });
                $('.btn.left.flashing').addClass('done');
                $('.btn.right').attr('disabled', 'disabled');
                $('#order ul').append('<li>Старые значения "'+$('.btn.left.flashing').data("name")+'" будут перемещены в "'+$(this).data("name")+'"</li>');
                $('#inputs').append('<input type="hidden" name="reconnect[]" value="'+$('.btn.left.flashing').data("id")+'|'+$(this).data("id")+'" />');
                $('.cancelbutton').removeClass('hide');
                endOldToNew();
            }

        } else {
            connectNewToOld = false;
            endNewToOld();
        }





    });


    $(".cancelbutton").click(function(){
        $('canvas').remove();
        mySVG = $('#linesContainer').connect();
        connectOldToNew = false;
        connectNewToOld = false;
        $('.btn.left').removeClass('done').removeClass('flashing').removeAttr('disabled');
        $('#order ul').empty();
        $('inputs').empty();
        $(this).addClass('hide');
    });

    function invokeOldToNew(selector){
        selector.addClass('flashing', function(){
            $('.btn.left:not(.flashing)').addClass('hides').attr('disabled', 'disabled');
        });
    }

    function endOldToNew(){
        $('.btn.left:not(.flashing)').removeClass('hides').removeAttr('disabled');
        $('.btn.left.flashing').removeClass('flashing');
        $('.btn.left.done').attr('disabled', 'disabled');
    }

    function invokeNewToOld(selector){
        selector.addClass('flashing', function(){
            $('.btn.right:not(.flashing)').addClass('hides').attr('disabled', 'disabled');
        });
    }

    function endNewToOld(){
        $('.btn.right:not(.flashing)').removeClass('hides').removeAttr('disabled');
        $('.btn.right.flashing').removeClass('flashing');
    }



    /*mySVG.drawLine({
        left_node:'.node1',
        right_node:'.node2',
        horizantal_gap:10
    });
    $( ".node1" ).draggable({
        drag: function(event, ui){mySVG.redrawLines();}
    });
    $( ".node2" ).draggable({
        drag: function(event, ui){mySVG.redrawLines();}
    });*/
JS;
$this->registerJs($script);
?>

<style>
    .flashing{
        animation: flash 2s infinite;
    }

    .hides{
        opacity: 0.2;
    }

    @keyframes flash {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.2;
        }
        100% {
            opacity: 1;
        }
    }

    #linesContainer{
        position: relative;
        height: <?=$i1+$i2?>px;
    }

    #linesContainer .btn.left{
        position: absolute;
        left: 0;
        width: 30%;
    }

    #linesContainer .btn.right{
        position: absolute;
        right: 0;
        width: 30%;
    }

    canvas{
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .btn{
        position: relative;
        z-index: 2;
    }
</style>

