<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 11.01.2016
 * Time: 14:30
 */
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin();

echo $form->field($model, 'name');
?>
<div id="tabs" class="text-center">
    <div id="tabc">
    <?php
    $i = 0;
    foreach($variants as $k=>$v):?>
        <div id="item-<?=$v->id?>" class="form-group input-group field-scquizvariants-<?=$k?>-name required">

            <input type="text" id="scquizvariants-<?=$v->id?>-name" class="var-input form-control" name="SCQuizVariants[<?=$v->id?>][name]" value="<?=$v->name?>">
            <span class="input-group-btn">
              <button type="button" data-item-id="<?=$v->id?>" class="btn btn-danger btn-flat deleteExisting"><i class="fa fa-times"></i></button>
            </span>
        </div>
    <?php $i=$k;endforeach;?>
    </div>
    <button type="button" id="addInput" class="btn btn-success btn-flat"><i class="fa fa-plus"></i></button>
</div>
<button type="submit" class="btn btn-success btn-block btn-flat">Сохранить</button>
<?php
ActiveForm::end();
?>

<style>
    div#tabs {
        background: #DEEDFF;
        padding: 20px;
    }
</style>

<?php
$script = <<< JS
var i = $i;
$(function(){
    $('#addInput').click(function(){
        $('#tabc').append('<div class="form-group input-group field-scquizvariants-new-'+i+'-name required">' +
         '<input type="text" placeholder="Вариант ответа" id="scquizvariants-new-'+i+'-name" class="form-control new" name="SCQuizVariantsNew[][name]" value="">' +
          '<span class="input-group-btn">' +
           '<button type="button" class="btn btn-danger btn-flat deleteNew"><i class="fa fa-times"></i></button>' +
            '</span></div>');
           i = i+1;
    });

    $('#tabc').on('click', '.deleteNew', function(){
        $(this).closest('.form-group').remove();
    });

    $('#tabc').on('click', '.deleteExisting', function(){
        $(this).closest('.form-group').hide();
        $(this).closest('.form-group').find('.var-input').remove();
        $(this).closest('.form-group').append('<input type="hidden" name="deleteVariant['+$(this).data('item-id')+']" value="1"/>');
    });

});
JS;

$this->registerJs($script);

?>
