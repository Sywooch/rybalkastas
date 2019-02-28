<?php
use kartik\sortable\Sortable;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\helpers\Url;




foreach($model as $at){

    $cnt = Editable::widget([
        'name'=>'name_ru['.$at->optionID.']',
        'asPopover' => false,
        'value' => $at->name_ru,
        'header' => 'название атрибута',
        'size'=>'md',
        'options' => [
            'class'=>'form-control',
            'placeholder'=>'Введите название атрибута',
            'id' => 'edtbl2_'.Yii::$app->security->generateRandomString(8),
        ],
        'formOptions' => [
            'action' => Url::toRoute(['/attributes/index'])
        ]
    ]);



    $ar[] = ['content' => "<span data-id=\"$at->optionID\" class=\"categoryID\">$cnt</span><span data-id=\"$at->optionID\" class=\"deleteattr\" style=\"float:right\">удалить</span><span data-id=\"$at->optionID\" class=\"fltredit\" style=\"float:right\">настроить фильтр &nbsp;&nbsp;&nbsp;</span> "];
}
?>



<p>- <?=$name;?></p>
<hr>
<?php if(!empty($ar)){
echo Sortable::widget([
    'items'=>$ar,
    'showHandle'=>true,
    'options'=>
        [
            'id'=>"attritems",
        ],
    'itemOptions' => [
        'class' => 'optionItem'
    ],
    'pluginEvents'=> [
        'sortupdate' => 'function() { updateSortOpt(); }',
    ]
]);
}
?>

<div class="modal fade" id="fltModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary savemodal" data-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.fltredit').click(function() {
        $.ajax({
            type: "POST",
            url: "<?=Url::to(['attributes/open-filter']);?>",
            data: {'id':$(this).data('id')},
            success: function(res){
                $('#fltModal .modal-body').html(res);
                $('#fltModal').modal();

            }
        });
    });

    $('.savemodal').click(function() {
        $.post($('#filterform').attr('action'), $('#filterform').serialize());
    });
</script>