<?php
$this->title = "Выгрузка товаров из 1С";

use yii\helpers\Json;
use backend\assets\TreeviewAsset;
use yii\widgets\Pjax;


TreeviewAsset::register($this);
?>

<div class="col-md-9">
    <div id="tree">
        <?php Pjax::begin();?>
        <?=$this->render('_contentsUt', ['nomenclature'=>$nomenclature, 'parent'=>$parent])?>
        <?php Pjax::end();?>
    </div>
</div>

<div class="col-md-3">
    <div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Товары к переносу</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php \yii\widgets\ActiveForm::begin(['action'=>['destination']]);?>
                <ol id="transferContainer">

                </ol>
                <button type="submit" id="submitTransfer" class="btn btn-primary btn-flat btn-block" disabled>Выбрать категорию для переноса</button>
                <?php \yii\widgets\ActiveForm::end();?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<script>
    function checkEnabled() {
        if ( $('#transferContainer li').length ) {

            $('#submitTransfer').prop('disabled', false);

        } else {
            $('#submitTransfer').prop('disabled', true);
        }
    }
</script>

<?php

$js = <<< JS
$('#tree').on('click', '.checkNomenclature',function(){
    code = $(this).data('code');
    name = $(this).closest('li').text();
    if(this.checked==true){
      $('#transferContainer').append('<li class="toadd" data-code="'+code+'">'+name+'<input type="hidden" name="codes[]" value="'+code+'"/></li>');
    }else{
      $('#transferContainer').find('li[data-code="'+code+'"]').remove();
    }
    checkEnabled();
});

$('#tree').on('click', '.selectAll',function(){
    $(this).closest('.box').find('input[type="checkbox"]').click();
    checkEnabled();
});
JS;

$this->registerJs($js);

?>
