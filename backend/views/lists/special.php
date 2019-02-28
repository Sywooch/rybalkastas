<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 13.10.2015
 * Time: 11:13
 */
use yii\jui\AutoComplete;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\widgets\Select2;
$this->title = "Спецпредложения";
?>
<div class="col-md-6">
    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Добавить товар</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div id="highlight_list" class="col-md-12">
                <?= $this->render("chunks/_special_list", ["list"=>$list]);?>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <a href="<?=\yii\helpers\Url::to(['/lists/clear-specials'])?>" type="button" class="btn btn-block btn-danger btn-lg">Очистить список</a>
        </div><!-- /.box-footer-->
    </div>
</div>
<div class="col-md-6">



<div class="box box-warning direct-chat direct-chat-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Добавить товар</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-12">
        <?php
        echo Select2::widget([
            "name"=>"selectedProduct",
            'options' => ['placeholder' => 'Найти товар', "id"=>"selectedProduct"],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'ajax' => [
                    'url' => \yii\helpers\Url::toRoute(["lists/load-product-list"]),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            ],
        ]);
        ?>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="button" id="addToList" class="btn btn-block btn-primary btn-lg">Добавить выбранный</button>
    </div><!-- /.box-footer-->
</div>

    <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Список товаров со скидкой</h3>
        </div><!-- /.box-header -->
        <div  style="height: 400px; overflow: scroll;" class="box-body">
            <div id="specialprds" class="col-md-12">
                <?php foreach($specials as $s):?>
                <ul class="products-list product-list-in-box">
                    <li class="item">

                        <div class="product-info">
                            <a href="javascript::;" class="product-title"><?=$s->name_ru?>
                                </a>
                            <?php if(!$s->inSpecials):?>
                                <span style="cursor: pointer" class="label label-warning pull-right addProduct" data-id="<?=$s->productID?>">Добавить</span>
                            <?php else:?>
                                <span class="label label-danger pull-right"">В списке</span>
                            <?php endif;?>
                        </div>
                    </li>
                </ul>
                <?php endforeach;?>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
           <!-- <button type="button" id="addAll" class="btn btn-block btn-warning btn-lg">Добавить все</button> -->
        </div><!-- /.box-footer-->
    </div>



</div>
<div class="clearfix"></div>

<script>
    function updateSort(){
        $('.optionItem').each(function(){
            $id = $(this).find('.productID').data('id');
            $('#resort').find('input[data-id='+$id+']').val($(this).index());
        });
        $("#savesort").show();
    }
    $(function(){
        $(".addProduct").click(function(e){
            e.stopImmediatePropagation();
            e.stopPropagation();
            $.ajax({
                type: "POST",
                url: "<?=\yii\helpers\Url::toRoute("lists/insert-specials")?>",
                data: {"id":$(this).data('id')},
                success: function(response){
                    $('#highlight_list').html(response);
                }
            });
        });

        $("#addToList").click(function(){
            if($("#selectedProduct").val()){
                $.ajax({
                    type: "POST",
                    url: "<?=\yii\helpers\Url::toRoute("lists/insert-specials")?>",
                    data: {"id":$("#selectedProduct").val()},
                    success: function(response){
                        $('#highlight_list').html(response);
                    }
                });
            }
        });

        $("#addAll").click(function(){
            $.ajax({
                type: "POST",
                url: "<?=\yii\helpers\Url::toRoute("lists/insert-specials-all")?>",
                data: {"all":"all"},
                success: function(response){
                    $('#highlight_list').html(response);
                }
            });
        });
    })
</script>