<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use backend\models\SCCategories;
use karpoff\icrop\CropImageUpload;
use yii\helpers\Url;
use yii\bootstrap\Html;

if($model->isNewRecord){
    $url = Url::toRoute(['/secondary/save-container']);
} else {
    $url = Url::to(['/secondary/save-container', 'id'=>$model->id]);
}

$form = ActiveForm::begin([
    'action' => $url,
]);

?>

<div class="form-group">
    <input type="hidden" name="item" value="<?=$item?>"/>
    <?= $form->field($model, 'name')->textInput() ?>
</div>

<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>



<?php ActiveForm::end();?>

