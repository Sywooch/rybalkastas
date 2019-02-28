<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;
use yii\jui\Draggable;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\sortable\Sortable;
use kartik\editable\Editable;
use kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SCProductOptionsCategoryesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Типы товаров</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="text-right">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => Url::to(['attributes/createcat']),
                    'options' => [
                        'id' => 'createnewcat'
                    ]
                ]);?>
                <?php $content = '
                <div class="input-group input-group-sm">
                    <input type="text" name="newCat" placeholder="Введите название типа" class="form-control">

                  </div>';
                echo PopoverX::widget([
                    'header' => "Создать тип товара",
                    'placement' => PopoverX::ALIGN_LEFT,
                    'content' => $content,
                    'footer'=>Html::submitButton('Создать', ['class'=>'btn btn-sm btn-primary', 'id'=>'submitCat']) .
                        Html::resetButton('Сброс', ['class'=>'btn btn-sm btn-default']),
                    'options'=>
                        [
                            'class'=>'popupwindow',
                            'id'=>'popup_'.Yii::$app->security->generateRandomString(8),
                        ],
                    'toggleButton' => ['label'=>'Создать тип', 'class'=>'btn btn-default'],
                ]);
                ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div id="category">
            <?=$this->render("_category", ['model'=>$model])?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Атрибуты</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => Url::to(['attributes/createattr']),
                'options' => [
                    'id' => 'createnewattr'
                ]
            ]);?>
            <?php $content = '
                <div class="input-group input-group-sm">
                    <input type="text" name="newAttr" placeholder="Введите название атрибута" class="form-control">

                  </div>';
            echo PopoverX::widget([
                'header' => "Создать атрибут",
                'placement' => PopoverX::ALIGN_RIGHT,
                'content' => $content,
                'footer'=>Html::submitButton('Создать', ['class'=>'btn btn-sm btn-primary', 'id'=>'submitAttr']) .
                    Html::resetButton('Сброс', ['class'=>'btn btn-sm btn-default']),
                'options'=>
                    [
                        'class'=>'popupwindow',
                        'id'=>'attrpopup',

                    ],
                'toggleButton' => ['label'=>'Создать атрибут', 'disabled'=>'disabled', 'class'=>'btn btn-default', 'id'=>'attrpopupbutton'],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
            <hr>
            <div id="attrtable">

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script>
    var selectedCategory = 0;
    function updateSort(){
        $('.categoryItem').each(function(){
            $id = $(this).find('.categoryID').data('id');
            $('#resort').find('input[data-id='+$id+']').val($(this).index());
        });
        $("#savesort").show();
    }

    $(function(){
        $('#category').on('click', '.categoryItem', function(e){
            if( e.target != this )
                return;
            $id =  $(this).find('.categoryID').data('id');
            $('#attrtable').append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
            $.ajax({
                url: "<?=Url::toRoute(['/attributes/load-attrs']);?>",
                type: "POST",
                data: {'id':$id},
                success: function (response) {
                    selectedCategory = $id;
                    $('#attrtable').html(response);
                    $('#attrpopupbutton').removeAttr('disabled');
                }
            });
        });

        $('#submitCat').click(function(e){
            e.preventDefault();
            $formdata = $('#createnewcat').serialize();
            $('.popupwindow').find('.close').click();
            $.ajax({
                url: $('#createnewcat').attr("action"),
                type: "POST",
                data: $formdata,
                success: function (response) {
                    $('#category').html(response);
                }
            });
        });

        $('#submitAttr').click(function(e){
            e.preventDefault();
            $formdata= $('.attrpopup').serialize();
            $('.popupwindow').find('.close').click();
            $.ajax({
                url: $('#createnewattr').attr("action"),
                type: "POST",
                data: "newAttr="+$('input[name="newAttr"]').val()+"&id="+selectedCategory,
                success: function (response) {
                    $('#attrtable').html(response);
                }
            });
        });

        $('#category').on('click', '.deletecat', function(){
            $id = $(this).data('id');
            $.ajax({
                url: "<?=Url::to(['attributes/deletecat'])?>",
                type: "POST",
                data: {"id" : $id},
                success: function (response) {
                    $('#category').html(response);
                }
            });
        });

        $('#attrtable').on('click', '.deleteattr', function(){
            $id = $(this).data('id');
            $.ajax({
                url: "<?=Url::to(['attributes/deleteattr'])?>",
                type: "POST",
                data: {"id" : $id},
                success: function (response) {
                    $('#attrtable').html(response);
                }
            });
        });

        $('body').on('click', "[data-toggle='popover-x']", function(e) {
            $(this).popoverX();
            var target = $(e.target).data('target');
            var options = {
                "backdrop": "true",
                "keyboard": "true",
                "show": "true"
            };
            $(target).popoverX($(this), options);
        });
    })
</script>

    <style>
        li{
            list-style-type: none;
            text-align: left;
        }

        ul{
            padding-left: 0;
        }

        #attrtable{
            position: relative;
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
    </style>


