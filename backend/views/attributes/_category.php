<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\sortable\Sortable;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use kartik\editable\Editable;

?>


<?php $ar = array();?>
<?php foreach($model as $item):?>

    <?php $cnt = Editable::widget([
        'name'=>'category_name_ru['.$item->categoryID.']',
        'asPopover' => false,
        'value' => $item->category_name_ru,
        'header' => 'название категории',
        'size'=>'md',
        'options' => [
            'class'=>'form-control',
            'placeholder'=>'Введите название категории',
            'id' => 'edtbl_'.Yii::$app->security->generateRandomString(8),
        ],
        'formOptions' => [
            'action' => Url::toRoute(['/attributes/index'])
        ]
    ]);?>

    <?php $ar[] = ['content' => "<span data-id=\"$item->categoryID\" class=\"categoryID\">$cnt</span><span data-id=\"$item->categoryID\" class=\"deletecat\" style=\"float:right\">удалить</span> "] ?>
<?php endforeach;?>
<?php
echo Sortable::widget([
    'items'=>$ar,
    'showHandle'=>true,
    'itemOptions' => [
        'class' => 'categoryItem'
    ],
    'pluginEvents'=> [
        'sortupdate' => 'function() { updateSort(); }',
    ]
]);
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::to(['attributes/index']),
    'options' => [
        'id' => 'resort'
    ]
]);?>
<input type="hidden" name="do_resort" value="1"/>
<?php foreach($model as $item):?>
    <input type="hidden" data-id="<?=$item->categoryID?>" name="resort[<?=$item->categoryID?>]" value="<?=$item->sort;?>" />
<?php endforeach;?>
<input style="display: none" id="savesort" type="submit" class="btn btn-success" value="Сохранить сортировку"/>
<?php ActiveForm::end(); ?>