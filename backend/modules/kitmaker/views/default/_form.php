<?php

use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data']
]);

?>

    <?=$form->field($model, 'name')->textInput();?>
    <?=$form->field($model, 'description')->textarea();?>
    <?php echo $form->field($model, 'picture')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'=>[
                (!empty($model->picture)?Html::img("/published/publicdata/TESTRYBA/attachments/SC/products_pictures/$model->picture", ['class'=>'file-preview-image', 'alt'=>$model->picture, 'title'=>$model->picture]):null),
            ],
            'initialCaption'=>$model->picture,
            'overwriteInitial'=>true,
            'showRemove' => true,
            'showUpload' => false,
            'browseLabel' =>  'Загрузить'
        ]


    ]); ?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Позиции</h3>
    </div>

    <?php
    $rootCats = \common\models\SCCategories::find()->where("parent = 1")->orderBy('sort_order')->all();
    echo '<label class="control-label">Сопутствующие товары</label><br/>';
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Выбрать сопуствующие</h2>',
        'toggleButton' => ['label' => 'Выбрать', 'class'=>'btn btn-success'],
    ]);
    echo '<div class="cattreemain" data-type="parents">';
    echo $this->render('modaltree', ['rootCats'=>$rootCats, 'static'=>1, 'treeId'=>1, 'type' => 'related', 'main'=>0]);
    echo '</div>';
    \yii\bootstrap\Modal::end();
    ?>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="progress">
            <div class="progress-bar progress-bar-primary progress-bar-striped" id="sharedBar" style="width: 0%">
                <span class="sr-only">40% Complete (success)</span>
            </div>
        </div>
        <table class="table table-striped">
            <tbody><tr>
                <th>Категория товаров</th>
                <th>Коэффициент</th>
                <th></th>
            </tr>
            <tr>
                <td><input name="NewKitElement[0][name]" class="form-control catFinder" type="text"/></td>
                <td><input name="NewKitElement[0][name]" class="form-control percentSetter" type="text"/></td>
                <td width="200px">
                    <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger percentHolder" data-width="0" style="width: 0%"></div>
                    </div>
                </td>
            </tr>
<tr>
                <td><input name="NewKitElement[0][name]" class="form-control catFinder" type="text"/></td>
                <td><input name="NewKitElement[0][name]" class="form-control percentSetter" type="text"/></td>
                <td width="200px">
                    <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger percentHolder" data-width="0" style="width: 0%"></div>
                    </div>
                </td>
            </tr>
<tr>
                <td><input name="NewKitElement[0][name]" class="form-control catFinder" type="text"/></td>
                <td><input name="NewKitElement[0][name]" class="form-control percentSetter" type="text"/></td>
                <td width="200px">
                    <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger percentHolder" data-width="0" style="width: 0%"></div>
                    </div>
                </td>
            </tr>
            </tbody>

            <tbody>
            <tr>
                <th>Количество категорий</th>
                <th>Итоговый коэффициент</th>
                <th></th>
            </tr>

            </tbody></table>
    </div>
    <!-- /.box-body -->
</div>

<?php $js = <<< JS
$('.percentSetter').change(function(){
    sharedW = 0;
    val = $(this).val();
    el = $(this).parent().parent().find('.percentHolder');
    el.css({'width':val+'%'});
    el.attr('data-width', val);

    $('.percentHolder').each(function(){
        sharedW = parseInt(sharedW) + parseInt($(this).attr('data-width'));
    });

    $('#sharedBar').css({width:sharedW+'%'});
    //alert(sharedW);

    if(sharedW > 100){
        $('#sharedBar').removeClass('progress-bar-primary').removeClass('progress-bar-green').addClass('progress-bar-red');
    } else if(sharedW < 100){
        $('#sharedBar').removeClass('progress-bar-red').removeClass('progress-bar-green').addClass('progress-bar-primary');
    } else {
        $('#sharedBar').removeClass('progress-bar-red').removeClass('progress-bar-primary').addClass('progress-bar-green');
    }

});
JS;

$this->registerJs($js);?>


<?php ActiveForm::end();?>
<script>
    $(function(){
        $('.cattreemain').on("click", "li:not(.loaded) i", function () {
            $curli = $(this).parent();

            $type = $curli.closest('.cattreemain').data('type');
            $curli.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
            $.ajax({
                url: "<?=Url::toRoute('/kitmaker/default/loadsubcatsajax');?>",
                type: "POST",
                data: {'root':$curli.data('cat'), 'type':'', 'main':1, 'type':$curli.data('type')},
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