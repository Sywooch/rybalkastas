<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.03.2016
 * Time: 8:42
 */

$form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::to(['update-filter', 'id'=>$model->optionID]),
    'options' => [
        'id' => 'filterform'
    ]
]);

?>
<div class="form-control">
    <?=$form->field($model, 'filter')->checkbox();?>
</div>
<div class="form-group">
    <?=$form->field($model, 'filterType')->dropDownList([
        'dropdown'=>'Дропдаун',
        'range'=>'Диапазон',
        'choose'=>'Выбор',
        'checkbox'=>'Чекбокс',
        'finder'=>'Чекбокс по установленным',
    ], ['class'=>'form-control']);?>
</div>
<div class="form-group">
    <?=$form->field($model, 'filterStep')->textarea(['class'=>'form-control', 'rows'=>5]);?>
</div>

<?php
\yii\widgets\ActiveForm::end();
?>
