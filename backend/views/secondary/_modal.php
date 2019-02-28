<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use common\models\SCCategories;
use karpoff\icrop\CropImageUpload;
use yii\helpers\Url;
use yii\bootstrap\Html;

if($model->isNewRecord){
    $url = Url::toRoute(['/secondary/save']);
} else {
    $url = Url::to(['/secondary/save', 'id'=>$model->link_id]);
}

$form = ActiveForm::begin([
    'action' => $url,
    'options' => ['enctype'=>'multipart/form-data'],
    'id'=>'link_form',
]);
if($model->isNewRecord)$model->link_type = 0;

?>

<?= $form->field($model, 'link_type')->radioList(
    [
        0 => 'Категория',
        1 => 'Прямая ссылка'
    ], [
    'item' => function ($index, $label, $name, $checked, $value) {
        return
            '<div class="radio"><label>' . Html::radio($name, $checked, ['value' => $value]) . $label . '</label></div>';
    },]);?>



<div class="linkToCat linkOpt" <?php if($model->link_type == 0):?>style="display:block;" <?php endif;?>>
    <button type="button" class="btn btn-success selectCat" data-toggle="modal">Добавить категорию</button>

    <div class="form-group hide">
        <?= $form->field($model, 'categoryID')->hiddenInput(['id'=>'catInput']);?>
        <?= $form->field($model, 'page_id')->hiddenInput(['value'=>$container]);?>
        <input type="hidden" name="item" value="<?=$item?>"/>
    </div>
    <div class="form-group">
        <label>Категория:</label>
        <span class="bold" id="selectedCategoryName"><?=(empty($model->categoryID)?"Категория не выбрана":SCCategories::find()->where("categoryID = $model->categoryID")->one()->name_ru)?></span>
    </div>
    <div class="form-group">
        <?php $mons = \yii\helpers\ArrayHelper::map(\common\models\SCMonufacturers::find()->orderBy("name ASC")->all(), 'id', 'name');?>
        <?php $additional = ['0'=>'Без маркера'];?>
        <?php $ar = $additional+$mons;?>
        <?= $form->field($model, 'mon_marker')->dropDownList($ar) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'tag_marker')->textInput() ?>
    </div>
</div>
<div class="linkToUrl linkOpt" <?php if($model->link_type == 1):?>style="display:block;" <?php endif;?>>
    <div class="form-group">
        <?= $form->field($model, 'custom_link')->textInput() ?>
    </div>
</div>
<div class="form-group">
    <?= $form->field($model, 'custom_name')->textInput() ?>
</div>
<div class="form-group">
    <?= $form->field($model, 'custom_image')->widget(CropImageUpload::className()) ?>
</div>
<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>



<?php ActiveForm::end();?>



<script>
    $('.selectCat').click(function() {
        $('#catModal').modal();
    });

    $('.cattreemain').on('click', '.selectCatBtn', function(){
        //alert($(this).parent().data('name'));
        $('#selectedCategoryName').html($(this).parent().data('name'));
        $('#catInput').val($(this).parent().data('cat'));
        $('#catModal').modal('hide');
    });

    $('#scsecondarypageslinks-link_type input').click(function(e){
        if($(this).val() == 0){
            //$('#link_form')[0].reset();
            $('.linkOpt').hide();
            $('.linkToCat').show();
        } else {
            //$('#link_form')[0].reset();
            $('.linkOpt').hide();
            $('.linkToUrl').show();
        }
    });
</script>
<style>
    .linkOpt{
        display: none;
    }
</style>