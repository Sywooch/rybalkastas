<?php
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php foreach($model as $m):?>

    <div data-id="<?=$m->id;?>" class="col-md-6 brand">
        <?php
        Modal::begin([
            'header' => '<h2>Изменить бренд</h2>',
            'toggleButton' => ['tag'=>'img', 'label' => 'Добавить изображение', 'src'=>'http://rybalkashop.ru/img/brandlogos/JPEG/'.$m->picture, 'style'=>'width:100%'],
            //'id' => 'insert-modal',
        ]);?>

        <?php $form = ActiveForm::begin([
            'action' => Url::toRoute(['/sidebarbrands/edit', 'id'=>$m->id]),
            'options' => ['enctype'=>'multipart/form-data'],
            'id' => 'mainpage-insert',
        ]); ?>

        <?= $form->field($m, 'picture')->widget(\karpoff\icrop\CropImageUpload::className(), ['options'=>['id'=>'crop_'.$m->id]]) ?>

        <?= $form->field($m, 'link') ?>

        <div class="form-group">
            <?= Html::submitButton($m->isNewRecord ? 'Создать' : 'Обновить', ['class' => $m->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'submitImg']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="form-group">
            <a href="<?=Url::to(['/sidebarbrands/delete', 'id'=>$m->id])?>" class="btn btn-danger">Удалить</a>
        </div>

        <?php
        Modal::end();
        ?>
    </div>

<?php endforeach;?>
