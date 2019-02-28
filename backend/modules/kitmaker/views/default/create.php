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
                <th></th>
                <th>Коэффициент</th>
                <th></th>
            </tr>

            <tbody id="kittr">
            <tr data-i="0">
                <td><input name="NewKitElement[0][name]" disabled class="form-control item_name" type="text"/></td>
                <td>
                    <button type="button" class="btn btn-primary btn-s show_modal" data-i="0" data-toggle="modal" data-target="#myModal">
                        Выбрать
                    </button>
                    <button type="button" class="btn btn-danger btn-s remove_row" data-i="0" data-toggle="modal" data-target="#myModal">
                        Удалить
                    </button>
                    <input type="hidden" class="item_id" name="NewKitElement[0][id]" value="">
                </td>
                <td><input name="NewKitElement[0][percent]" class="form-control percentSetter item_percent" value="0" type="text"/></td>
                <td width="200px">
                    <div class="progress progress-xs">
                        <div class="progress-bar progress-bar-danger percentHolder" data-width="0" style="width: 0%"></div>
                    </div>
                </td>
            </tr>
            </tbody>
            </tbody>

            <tbody>
            <tr>
                <th><a href="#" class="btn btn-primary" id="addCat">Добавить категорию</a></th>
                <th>Количество категорий</th>
                <th>Итоговый коэффициент</th>
                <th></th>
            </tr>

            </tbody></table>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Выбрать категорию</h4>
                </div>
                <div class="modal-body">
                    <?php
                    echo '<div class="cattreemain" data-type="parents">';
                    echo $this->render('modaltree', ['rootCats'=>$rootCats, 'static'=>1, 'treeId'=>1, 'type' => 'related', 'main'=>0]);
                    echo '</div>';
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.box-body -->
</div>

<?php $js = <<< JS

var last_new = 0;
var modal_selector = 0;
$('#kittr').on('click', '.show_modal', function(){
    modal_selector = $(this).data('i');
});

$('#kittr').on('click', '.remove_row', function(){
    $('#kittr tr[data-i="'+$(this).data('i')+'"]').remove();
});

$('#kittr').on('change', '.percentSetter', function(){
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

$('#addCat').click(function(e){
    e.preventDefault();
    last_new = last_new + 1;
    $('#kittr').append('<tr data-i="'+last_new+'">'+
                '<td><input name="NewKitElement['+last_new+'][name]" disabled class="form-control item_name" type="text"/></td>'+
                '<td>'+
                    '<button type="button" class="btn btn-primary btn-s show_modal" data-i="'+last_new+'" data-toggle="modal" data-target="#myModal">'+
                        'Выбрать'+
                    '</button>'+
                    '<button type="button" class="btn btn-danger btn-s remove_row" data-i="0" data-toggle="modal" data-target="#myModal">'+
                        'Удалить'+
                    '</button>'+
                    '<input type="hidden" class="item_id" name="NewKitElement['+last_new+'][id]" value="">'+
                '</td>'+
                    '<td><input name="NewKitElement['+last_new+'][percent]" value="0" class="form-control percentSetter item_percent" type="text"/></td>'+
                '<td width="200px">'+
                    '<div class="progress progress-xs">'+
                        '<div class="progress-bar progress-bar-danger percentHolder" data-width="0" style="width: 0%"></div>'+
                    '</div>'+
                '</td>'+
            '</tr>');
});

$('.cattreemain').on('click','.category_chooser',function(e){
    e.preventDefault();
    el = $('#kittr tr[data-i="'+modal_selector+'"]');
    el.find('.item_name').val($(this).data('name'));
    el.find('.item_id').val($(this).data('cat'));
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