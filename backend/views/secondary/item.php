<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\SCCategories;
use yii\jui\JuiAsset;
$rootCats = SCCategories::find()->where("parent = 1")->orderBy('main_sort')->all();
JuiAsset::register($this);
$main = 1;
?>
<div class="col-md-3">
    <?=$this->render("_left", ['id'=>$model->id]);?>
</div>
<div class="col-md-9">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?=$model->name;?></h3>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="<?=($tab=="linksset"?"active":"");?>"><a href="#linksset" data-toggle="tab" aria-expanded="false">Ссылки</a></li>
                    <li class="<?=($tab=="slideset"?"active":"");?>"><a href="#slideset" data-toggle="tab" aria-expanded="false">Слайды</a></li>
                    <li class="<?=(!isset($tab)?"active":"");?>"><a href="#mainset" data-toggle="tab" aria-expanded="true">Основные</a></li>
                    <li class="pull-left header">Настройки</li>
                </ul>
                <?php $form = ActiveForm::begin([
                    'options'=>['enctype'=>'multipart/form-data']
                ]); ?>
                <div class="tab-content no-padding">
                    <div class="chart tab-pane <?=(!isset($tab)?"active":"");?>" id="mainset">

                        <div class="form-group">
                            <?=$form->field($model, 'name');?>
                        </div>
                        <?php echo $form->field($model, 'head_image')->widget(\kartik\file\FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                            'pluginOptions' => [
                                'initialPreview'=>!empty($model->head_image)?[
                                    \yii\helpers\Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/products_pictures/$model->head_image"), ['class'=>'file-preview-image', 'alt'=>$model->head_image, 'title'=>$model->head_image]),
                                ]:false,
                                'initialCaption'=>$model->head_image,
                                'overwriteInitial'=>true,
                                'showRemove' => true,
                                'showUpload' => false,
                                'browseLabel' =>  'Загрузить'
                            ]
                        ]); ?>

                        <?php echo $form->field($model, 'link_image')->widget(\kartik\file\FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                            'pluginOptions' => [
                                'initialPreview'=>!empty($model->link_image)?[
                                    \yii\helpers\Html::img(\Yii::$app->urlManagerFrontend->createAbsoluteUrl("/img/brand_pictures/$model->link_image"), ['class'=>'file-preview-image', 'alt'=>$model->link_image, 'title'=>$model->link_image]),
                                ]:false,
                                'initialCaption'=>$model->link_image,
                                'overwriteInitial'=>true,
                                'showRemove' => true,
                                'showUpload' => false,
                                'browseLabel' =>  'Загрузить'
                            ]
                        ]); ?>

                        <div class="form-group">
                            <?= $form->field($model, 'brand')->dropDownList(ArrayHelper::map(\common\models\SCMonufacturers::find()->orderBy("name ASC")->all(), 'id', 'name'), ['prompt'=>'Выбрать бренд']) ?>
                        </div>
                        <div class="form-group">
                            <?=$form->field($model, 'alias');?>
                        </div>
                        <?php if(!$model->isNewRecord):?>
                            Ссылка для вставки в бренд: <span class="lnk_copy">/brands/alias=<?=$model->alias;?></span>
                        <?php endif;?>
                        <div class="form-group">
                            <?=$form->field($model, 'description')->widget(Widget::className(), [
                                'settings' => [
                                    'imageUpload' => Url::to(['/news/image-upload']),
                                    'lang' => 'ru',
                                    'minHeight' => 200,
                                    'plugins' => [
                                        'clips',
                                        'fullscreen'
                                    ]
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="chart tab-pane <?=($tab=="slideset"?"active":"");?>" id="slideset">

                    </div>
                    <div class="chart tab-pane <?=($tab=="linksset"?"active":"");?>" id="linksset">
                        <div class="col-md-9">
                        <?php foreach($model->containers as $c):?>
                            <div class="box primary containerFull" data-container_id="<?=$c->id;?>" >
                                <div class="box-header">
                                    <?=$c->name;?>
                                    <div style="float: right">
                                        <button type="button" data-container_id="<?=$c->id;?>" class="btn btn-success addLink" data-toggle="modal">Добавить ссылку</button>
                                    </div>
                                </div>
                                <div data-container="<?=$c->id;?>" class="box-body containerContent">
                                    <?=$this->render("_container",['c'=>$c]);?>
                                </div>
                            </div>
                        <?php endforeach;?>
                        </div>
                        <div class="col-md-3">
                            <h3>Контейнеры</h3>


                            <div class="box warning">
                                <div class="box-header">
                                    <div>
                                        <button type="button" class="btn btn-success addContainer" data-toggle="modal">Добавить контейнер</button>
                                    </div>
                                </div>
                                <div class="box-body" id="containersBlock">
                                    <ul class="todo-list container-list">

                                    <?php foreach($model->containers as $c):?>

                                            <li data-container_id="<?=$c->id;?>">
                                                <!-- drag handle -->
                                                  <span class="handle ui-sortable-handle">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                  </span>
                                                <!-- checkbox -->
                                                <!-- todo text -->
                                                <span class="text"><?=$c->name;?></span>
                                                <!-- Emphasis label -->
                                                <!-- General tools such as edit or delete-->
                                                <div class="tools">
                                                    <i data-container_id="<?=$c->id;?>" class="fa fa-edit editContainer"></i>
                                                    <i data-container_id="<?=$c->id;?>" class="fa fa-trash-o deleteContainer"></i>
                                                </div>
                                            </li>
                                    <?php endforeach;?>
                                    </ul>

                                </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    </div>
                    <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
        <div style="clear: both;"></div>

    </div>
    <div style="clear: both;"></div>


    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить ссылку</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="itemEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Редактировать ссылку</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Выбрать категорию</h4>
            </div>
            <div class="modal-body">
                <div class="cattreemain" data-type="parents">
                    <?=$this->render('modaltree', ['rootCats'=>$rootCats, 'static'=>1, 'treeId'=>1, 'type' => 'childs', 'main'=>$main]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="contModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить контейнер</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="contModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать контейнер</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>



<script>
    $('.addLink').click(function() {
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/link']);?>",
            data: {'c_id':$(this).data('container_id'), 'item':<?=$model->id?>},
            success: function(res){
                $('#itemModal .modal-body').html(res);
                $('#itemModal').modal();

            }
        });
    });

    $('.editLink').click(function() {
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/link']);?>",
            data: {'c_id':$(this).data('container_id'), 'id':$(this).data('item_id'), 'item':<?=$model->id?>},
            success: function(res){
                $('#itemModal .modal-body').html(res);
                $('#itemModal').modal();

            }
        });
    });

    $('.deleteItem').click(function(){
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/delete']);?>",
            data: {'id':$(this).data('item_id')},
            success: function(res){
                $(this).parent().parent().remove();
            }
        });
    });

    $('.addContainer').click(function() {
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/container']);?>",
            data: {'item':<?=$model->id?>},
            success: function(res){
                $('#contModal .modal-body').html(res);
                $('#contModal').modal();
            }
        });
    });

    $('.editContainer').click(function() {
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/container']);?>",
            data: {'c_id':$(this).data('container_id'), 'item':<?=$model->id?>},
            success: function(res){
                $('#contModalEdit .modal-body').html(res);
                $('#contModalEdit').modal();
            }
        });
    });

    $('.deleteContainer').click(function(){
        $item = $(this);
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['secondary/delete-container']);?>",
            data: {'id':$(this).data('container_id')},
            success: function(res){
                $('.containerFull[data-container_id='+$item.data('container_id')+']').remove();
                $('.container-list li[data-container_id='+$item.data('container_id')+']').remove();
            }
        });
    });
</script>

<script>
    $(function(){
        $('.container-list').sortable({
            update: function (event, ui) {
                $cid = ui.item.data('container_id');
                if ( ui.item.next('li').length ) {
                    $nextCid =  ui.item.next('li').data('container_id');
                    $('.containerFull[data-container_id='+$cid+']').insertBefore($('.containerFull[data-container_id='+$nextCid+']'));
                } else {
                    $('.containerFull[data-container_id='+$cid+']').appendTo($('#linksset .col-md-9'));
                }

                $('.container-list li').each(function(){
                    $.ajax({
                        url: "<?=Url::toRoute('/secondary/reorder-containers');?>",
                        type: "POST",
                        data: {'id':$(this).data('container_id'),'order':$(this).index()},
                        success: function (response) {

                        }
                    });
                });
            }
        });



        $('.containerContent').sortable({
            update: function (event, ui) {
                $('.containerContent[data-container="'+ui.item.data('container_id')+'"] .tile').each(function(){
                    $('#ls_'+$(this).data('item_id')).val($(this).index());
                    
                });
            }
        });


        $('.cattreemain').on("click", "li:not(.loaded) i", function () {
            $curli = $(this).parent();

            $type = $curli.closest('.cattreemain').data('type');
            $curli.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
            $.ajax({
                url: "<?=Url::toRoute('/secondary/loadsubcatsajax');?>",
                type: "POST",
                data: {'root':$curli.data('cat'), 'type':$type, 'main':<?=$main;?>, 'type':$curli.data('type')},
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

<div style="clear: both"></div>

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

    span.lnk_copy {
        border: solid 1px;
        padding: 6px;
    }

</style>