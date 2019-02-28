<?php $form = \yii\widgets\ActiveForm::begin(['action'=>\yii\helpers\Url::to(['/experts/edit','id'=>$model->id])]); ?>
<?= $form->field($model, 'message')->textarea(['rows' => 5])->label(false); ?>
<button type="submit" class="btn btn-success pull-right">Отправить</button>

<?php \yii\widgets\ActiveForm::end(); ?>

<div class="clearfix"></div>
