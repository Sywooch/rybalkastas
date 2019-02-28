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
                <h3 class="box-title">Выберите товары для установки тега "<?=$cat->category_name_ru?>" как атрибут</h3><br>
                <small>Список содержит только позиции, имеющие этот тег.</small>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 12%"></div>
                </div>

            </div><!-- /.box-header -->
            <div class="clearfix"></div>
            <?php $form = ActiveForm::begin(['action'=>['step3']]); ?>
            <input type="hidden" name="attrCat" value="<?=$cat->categoryID;?>"
            <div class="box-body">
                <div class="cattreemain">
                    <ul class="catlist">
                        <?php foreach($rootCats as $item):?>
                            <li data-cat="<?=$item->categoryID?>"><?php if($item->hasChilds):?>
                                    <i class="fa fa-folder"></i><?php endif;?>
                                <span><?=$item->name_ru?></span>
                                <?=CheckboxX::widget(
                                    [
                                        'name'=>'connect'.'['.$item->categoryID.']',
                                        'options'=>['id'=>$item->categoryID],
                                        'value'=>0,
                                        'pluginOptions'=>[
                                            'size'=>'xs',
                                            'threeState'=>false,
                                        ]
                                    ]);
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div><!-- /.box-body -->
            <?= Html::submitButton("Далее", ['class' => 'btn btn-block btn-success pull-right']) ?>
            <?php ActiveForm::end(); ?>
            <div class="clearfix"></div>
        </div><!-- /.box -->
    </div>
    <div class="clearfix"></div>
</div>

<script>
    $(function(){
        $('.cattreemain').on("click", "li:not(.loaded) i", function () {
            $curli = $(this).parent();
            $curli.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
            $.ajax({
                url: "<?=Url::toRoute('/categories/loadsubcatsajax');?>",
                type: "POST",
                data: {'root':$curli.data('cat'), 'type':"connect", 'main':1},
                success: function (response) {
                    $curli.addClass('loaded');
                    $curli.children('.preloader').remove();
                    $curli.append(response);
                    $curli.find('.catlist').toggle(300);
                    checkFolders();
                }
            });

        });

        $('.cattreemain').on("click", "li.loaded i", function () {
            $curli = $(this).parent();
            $curli.find('ul').toggle(300, function(){
                checkFolders();
            });

        });

        $('.cattreemain').on("click", "li span", function () {
            $curli = $(this).parent();
            $('.cattreemain li').removeClass('selected');
            $curli.addClass('selected');
            $prds = $('.prdtreemain');
            $prds.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
            $.ajax({
                url: "<?=Url::toRoute('/categories/loadprds');?>",
                type: "POST",
                data: {'cat':$curli.data('cat')},
                success: function (response) {
                    $prds.children('.preloader').remove();
                    $prds.find('.prdlist').hide(300, function(){
                        $prds.html(response);
                        $prds.find('.prdlist').show(300);
                    });

                }
            });

        });



    });

    function checkFolders(){
        $('.cattreemain li').each(function(){
            $tocheck = $(this).find('ul');
            if($tocheck.is(':visible')){
                $(this).children('i').addClass('fa-folder-open');
            } else {
                $(this).children('i').removeClass('fa-folder-open');
            }
        })
    }
</script>

<style>
    .cattreemain ul li {
        display: block;
        padding: 10px;
        margin-left: 5px;
        background: #fff;
        border: solid 1px #ECF0F5;
        cursor: pointer;
        position: relative;
        text-align: left;
    }

    .cattreemain i {
        margin-right: 10px;
    }

    .cattreemain ul{
        padding:0;
    }



    .cattreemain li.highlight {
        background: #c1ffd3;
    }

    .prdtreemain i {
        margin-right: 10px;
    }

    .prdtreemain ul{
        padding:0;
    }

    .preloader {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        background-color: rgba(139, 139, 139, 0.58);
    }

    .preloader i {
        line-height: 40px;
    }

    .cbx-container {
        float: right;
    }

    ul.sublist li {
        list-style-type: none;
        text-align: left;
        padding: 5px;
        background: #f1f1f1;
        border: solid 1px #D9D9D9;
    }

    ul.sublist{
        padding: 0;
    }

</style>

