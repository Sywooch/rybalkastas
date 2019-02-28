<?php \yii\widgets\ActiveForm::begin(['action'=>['/shop-admin/submit-edit-page', 'id'=>$model->getPrimaryKey()], 'id'=>'pageForm'])?>

    <div class="pull-right">
        <button type="button" onclick="cancelEditPage()" class="btn btn-flat btn-danger cancelEditing" data-toggle="tooltip" title="Отмена"><i class="fa fa-times"></i></button>
        <button type="button" onclick="submitEditPage()" class="btn btn-flat btn-success cancelEditing" data-toggle="tooltip" title="Сохранить"><i class="fa fa-check"></i></button>
    </div>
    <div class="clearfix"></div>
<?php echo froala\froalaeditor\FroalaEditorWidget::widget([
    'model' => $model,
    'attribute' => 'aux_page_text_ru',
    'options'=>[// html attributes
        'id'=>'content'
    ],
    'clientOptions'=>[
        'toolbarInline'=> true,
        'theme' =>'royal',//optional: dark, red, gray, royal
        'language'=>'ru', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
        'imageUploadParam'=> 'file',
        'imageUploadURL'=> \yii\helpers\Url::to(['shop-admin/upload/']),
        'fileUploadParam'=> 'file',
        'fileUploadURL'=> \yii\helpers\Url::to(['shop-admin/upload-file/']),
        'videoUploadParam'=> 'file',
        'videoUploadURL'=> \yii\helpers\Url::to(['shop-admin/upload-file/']),
        'imageManagerLoadURL' => \yii\helpers\Url::to(['shop-admin/load-images/']),
        'imageManagerDeleteURL' => \yii\helpers\Url::to(['shop-admin/delete-images/'])
    ],
    'value'=>$model->aux_page_text_ru
]);
?>
<?php
\yii\widgets\ActiveForm::end();
?>

<style>
    a[href="https://www.froala.com/wysiwyg-editor?k=u"]{
        display: none!important;
    }
</style>
<script>
    function submitEditPage(){
        $.post( $('#pageForm').attr('action'), $('#pageForm').serialize(), function( data ) {
            $("#static_page").html( data );
        });
    }

    function cancelEditPage(){
        $.post( $('#pageForm').attr('action'), function( data ) {
            $("#static_page").html( data );
        });
    }
</script>
