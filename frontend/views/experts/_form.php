<div class="comment_container_inner">
    <?php $form = \yii\widgets\ActiveForm::begin(['action'=>\yii\helpers\Url::to(['/experts/expert','id'=>$model->expert_id])]); ?>
    <?= $form->field($newPost, 'post_id')->hiddenInput(['value' => $model->id])->label(false); ?>
    <?= $form->field($newPost, 'message')->textarea(['rows' => 5]); ?>
    <button type="submit" class="btn btn-success pull-right">Отправить</button>
    <div class="clearfix"></div>
    <br/>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
