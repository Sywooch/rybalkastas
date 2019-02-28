<?php
/* @var $this yii\web\View */
$this->title = 'Боковые бренды';
use backend\assets\JuiAsset;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use karpoff\icrop\CropImageUpload;
use yii\helpers\Html;
JuiAsset::register($this);
?>

<div class="col-md-offset-3 col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Бренды</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-4 col-md-offset-4">
                <?php
                Modal::begin([
                    'header' => '<h2>Добавить бренд</h2>',
                    'toggleButton' => ['label' => 'Добавить новый', 'class'=>'btn btn-primary btn-block'],
                    'id' => 'insert-modal',
                ]);?>

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/sidebarbrands/insert']),
                    'options' => ['enctype'=>'multipart/form-data'],
                    'id' => 'mainpage-insert',
                ]); ?>

                <?= $form->field($newbrand, 'picture')->widget(CropImageUpload::className()) ?>

                <?= $form->field($newbrand, 'link')->textInput(); ?>

                <div class="form-group">
                    <?= Html::submitButton($newbrand->isNewRecord ? 'Создать' : 'Обновить', ['class' => $newbrand->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                <?php
                Modal::end();
                ?>
            </div>
            <div id="brands" class="col-md-4 col-md-offset-4">
                <?=$this->render('_brands', ['model'=>$model]);?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<style>
    .brands {
        background: #F6F6F6;
    }

    .brands .brand {
        margin: 5px 0;
        height: 45px;
        cursor: pointer;
    }

    .placeholder {
        border: 1px solid green;
        background-color: white;
        -webkit-box-shadow: 0px 0px 10px #888;
        -moz-box-shadow: 0px 0px 10px #888;
        box-shadow: 0px 0px 10px #888;
        height: 55px;
    }

</style>

<script>
    $(function(){

        $('#brands').sortable({
            tolerance: 'pointer',
            revert: 'invalid',
            placeholder: 'col-md-6 well placeholder tile',
            forceHelperSize: true,
            stop: function( ) {
                $('#brands .brand').each(function(){
                    index = $(this).index();
                    id = $(this).attr('data-id');
                    $.post( "<?=Url::toRoute(['/sidebarbrands/sort'])?>", { id: id, sort: index });
                })
            }
        });

    })
</script>
