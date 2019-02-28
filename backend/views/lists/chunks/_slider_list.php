<?php
use kartik\sortable\Sortable;
use kartik\popover\PopoverX;
use yii\helpers\Html;
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php foreach($list as $l):?>
    <?php if(!$l->product)continue;?>

    <?php
    $after = '';
    if($l->product->in_stock <= 0){
        $after = '(нет в наличии)';
    }
    ?>
    <?php $ar[] =['content'=>'
                <div class="productID" data-id="'.$l->product->productID.'"></div>
                <img style="height:60px" src="/published/publicdata/TESTRYBA/attachments/SC/products_pictures/'.$l->product->picurl.'" />
                <span>'.$l->product->name_ru.$after.'</span>
                <span data-id="46" data-product="'.$l->product->productID.'" class="deletePrd" style="float:right;cursor:pointer;"><i class="fa fa-times"></i></span>

'];?>
<?php endforeach;?>

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
            'sortupdate' => 'function() { updateSort(); }',
        ]
    ]);
}
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::to(['lists/specials-slider']),
    'options' => [
        'id' => 'resort'
    ]
]);?>
<input type="hidden" name="do_resort" value="1"/>
<?php foreach($list as $item):?>
    <input type="hidden" data-id="<?=$item->product_id?>" name="resort[<?=$item->product_id?>]" value="<?=$item->sort_order;?>" />
<?php endforeach;?>
<input style="display: none" id="savesort" type="submit" class="btn btn-success" value="Сохранить сортировку"/>
<?php ActiveForm::end(); ?>

<script>
    $(function(){
        $(".deletePrd").click(function(){
            if($(this).data("product")){
                $.ajax({
                    type: "POST",
                    url: "<?=\yii\helpers\Url::toRoute("lists/delete-specials-slider")?>",
                    data: {"id":$(this).data("product")},
                    success: function(response){
                        $('#highlight_list').html(response);
                    }
                });
            }

        });
    })
</script>