<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Html;

?>

<?php foreach($model as $m):?>
    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['/content/slider/edit', 'id'=>$m->id]),
        'options'=>['class'=>'slideedit', 'data-id'=>$m->id]
    ]); ?>
    <div class="well well-sm" data-sort="<?=$m->sort_order;?>">
        <div >
            <i class="fa fa-bars sort"   style="cursor: move"></i>&nbsp;
            <i class="fa fas fa-edit edit" style="cursor: pointer"></i>&nbsp;
            <i class="fa fa-trash trash" style="cursor: pointer; color: red;"></i>
        </div>
        <div class="rel">
            <img <?php echo $m->disabled ? "style=\"opacity:0.2;\"" : "" ?> src="http://rybalkashop.ru/img/slider/<?=$m->image;?>"/>
            <div class="slidelabel" data-id="<?=$m->id?>" style="top: <?=$m->offset_y;?>px;left: <?=$m->offset_x;?>px;">
                <h2 id="slide_<?=$m->id;?>"><span style="background: <?=$m->bgcolor;?>; color: <?=$m->txtcolor;?>" class=""><?=$m->text?></span></h2>
                <div id="menu_<?=$m->id;?>" class="slidemenu">
                    <div class="text-right">
                        <span data-id="<?=$m->id?>" class="closemenu">
                            <i class="fa fa-times" style="color:red"></i>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($m, "text")->textInput(['class'=>'text form-control', 'data-id'=>$m->id]) ?>
                        <?= $form->field($m, "url")->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($m, "txtcolor")->textInput(['class'=>'jscolor {hash:true} txtcolor form-control', 'data-id'=>$m->id]) ?>
                        <?= $form->field($m, "bgcolor")->textInput(['class'=>'jscolor {hash:true} bgcolor form-control', 'data-id'=>$m->id]) ?>
                        <?= $form->field($m, 'disabled')->widget(\kartik\widgets\SwitchInput::classname(),[
                            'pluginOptions'=>[
                                'onText'=>'Да',
                                'offText'=>'Нет'
                            ], 'options' => ['id'=>'disabler_'.$m->id]
                        ]); ?>
                    </div>
                    <div style="display: none">
                        <?= $form->field($m, "offset_x")->hiddenInput(['class'=>'offset_x']) ?>
                        <?= $form->field($m, "offset_y")->hiddenInput(['class'=>'offset_y']) ?>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Обновить</button>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php endforeach;?>

<style>
    .well{
        text-align: center;
    }
    .rel{
        position: relative;
        display: inline-block;
    }

    .rel h2{
        margin: 0;
    }

    .slidelabel h2{
        cursor: pointer;
        font-size: 13px;
        font-family: arial,helvetica, sans-serif;
    }

    .slidelabel h2 span{
        display: block;
        border-radius: 3px;
        padding: 10px 15px;
        min-width: 200px;
    }

    .slidelabel{
        position: absolute;
    }
    .slidemenu {
        display: none;
        position: absolute;
        right: -204px;
        top: 0;
        background: #FFF;
        padding: 20px;
        border: solid 1px #00A65A;
        z-index: 9;
    }
    .closemenu{
        cursor: pointer;
    }
</style>

<script>
    $(function(){
        $('.txtcolor').change(function(){
            id = $(this).data('id');
            $('#slide_'+id+' span').css({'color':'#'+$(this).val()})
        });
        $('.bgcolor').change(function(){
            id = $(this).data('id');
            $('#slide_'+id+' span').css({'background-color':'#'+$(this).val()})
        });
        $('.text').on("input", function() {
            id = $(this).data('id');
            $('#slide_'+id+' span').html($(this).val())
        });
        $('.edit').click(function(){
            $(this).parent().parent().find('.slidemenu').show();
        });
        $('.trash').click(function (){
            if (confirm("Хотите удалить баннер из слайдера?")) {
                let bannerId = $(this).parent().parent().parent().data('id');

                $.ajax({
                    url:  "/content/slider/remove",
                    type: "POST",
                    data: { "id" : bannerId },
                    success: function(response) {
                        if (Boolean(response) === true) {
                            $("form[data-id = " + bannerId + "]").remove();
                        }
                    }
                });
            }
        });
        $(".slidelabel").on("dragstop",function(ev,ui){
            xtop = $(this).css('top');
            left = $(this).css('left');
            id = $(this).data('id');
            $(this).find('.offset_x').val(left.replace("px",""));
            $(this).find('.offset_y').val(xtop.replace("px",""));
        });
        $('.slideedit').submit(function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $.post( $(this).attr('action'), $(this).serialize(), function( data ) {
                alert(data);
            });
        });
        $('.closemenu').click(function(){
            id = $(this).data('id');
            $('#menu_'+id).hide();
        });
    })
</script>