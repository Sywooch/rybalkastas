<?php
use yii\widgets\ActiveForm;
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
            <?php $form = ActiveForm::begin([
                'options'=>['enctype'=>'multipart/form-data']
            ]); ?>

            <?=$form->field($model, 'name');?>

            <?=$form->field($model, 'alias');?>

            <?=$form->field($model, 'brand')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\SCMonufacturers::find()->orderBy(['name'=>SORT_DESC])->all(),'id','name'))?>

            <?= \yii\helpers\Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>