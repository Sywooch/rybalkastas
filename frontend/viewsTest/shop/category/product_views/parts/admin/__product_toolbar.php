<div class="pull-right">
    <a data-pjax="false" class="btn btn-flat btn-warning editproduct" href="<?=\yii\helpers\Url::to(['/shop-admin/sync-ut', 'id'=>$model->productID])?>" data-toggle="tooltip" title="Синхронизировать с 1С"><i class="fa fa-cloud-download"></i></a>
    <a class="btn btn-flat btn-info editproduct" href="<?=\yii\helpers\Url::to(['/shop-admin/render-edit-product', 'id'=>$model->productID])?>" data-toggle="tooltip" title="Редактировать товар"><i class="fa fa-pencil"></i></a>
    <a class="btn btn-flat btn-info red " href="<?=\Yii::$app->urlManagerBackend->createAbsoluteUrl(['categories/editproduct', 'id'=>$model->productID])?>" target="_blank" data-toggle="tooltip" title="Редактировать в админке"><i class="fa fa-pencil"></i></a>
</div>

<div class="clearfix"></div>





<?php
$js = <<< JS

$('.editproduct').click(function(e){
    e.preventDefault();
    $(this).attr('disabled','disabled');
    $.post( $(this).attr('href'), function( data ) {
      $("#productContainer").html( data );
    });
});

JS;
$this->registerJs($js);
?>