<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Html;
?>
<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['/content/front-grid/serialize']),
    'id' => 'grid-form',
]); ?>
<style>
    .grid-controls {
        position: absolute;
        top: 0;
        bottom: 0;
        left:0;
        right:0;
        margin: auto;
        width: 100%;
        text-align: center;
        height: 30%;
        display: none;
    }

    .gridster li:hover .grid-controls{
        display: block;
    }

    .grid-controls .fa-circle{
        color: #ff2121;
    }

    .grid-controls .remove{
        cursor: pointer;
    }

    .grid-controls .handle{
        cursor: move;
    }
</style>
<div class="gridster" id="layouts_grid">
    <ul>
        <?php foreach($model as $m):?>
            <li class="layout_block" pic-id="<?=$m->id;?>" data-row="<?=$m->y;?>" data-col="<?=$m->x;?>" data-sizex="<?=$m->width;?>" data-sizey="<?=$m->height;?>" style="background-image:url('http://rybalkashop.ru/img/mainpage/start/<?=$m->picture;?>'); background-size:100% 100%;">
                <div class="inputs" style="display: none">
                    <?= $form->field($m, "[$m->id]picture")->hiddenInput() ?>
                    <?= $form->field($m, "[$m->id]url")->hiddenInput() ?>
                    <?= $form->field($m, "[$m->id]x")->hiddenInput() ?>
                    <?= $form->field($m, "[$m->id]y")->hiddenInput() ?>
                    <?= $form->field($m, "[$m->id]width")->hiddenInput() ?>
                    <?= $form->field($m, "[$m->id]height")->hiddenInput() ?>
                </div>
                <div class="grid-controls">
                        <span class="fa-stack fa-lg handle">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-hand-rock-o fa-stack-1x fa-inverse"></i>
                        </span>

                        <span class="fa-stack fa-lg remove" data-id="<?=$m->id;?>">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                        </span>
                </div>
            </li>

        <?php endforeach;?>
    </ul>
</div>

<button type="button" id="serialize" class="btn btn-warning btn-block">Обновить</button>


<?php ActiveForm::end(); ?>

<script>
    $( document ).ready(function() {
        var grid_size = 100;
        var grid_margin = 10;
        var block_params = {
            max_width: 6,
            max_height: 6
        };


        var gridster = $("#layouts_grid ul").gridster({
            widget_margins: [grid_margin, grid_margin],
            widget_base_dimensions: [grid_size, grid_size],
            draggable: {
                handle: '.grid-controls .handle i'
            },
            serialize_params: function($w, wgd) {
                return {
                    x: wgd.col,
                    y: wgd.row,
                    width: wgd.size_x,
                    height: wgd.size_y,
                    id: $($w).attr("pic-id"),
                    class: $($w).attr("class")
                }
            }
        }).data("gridster");

        $(".layout_block").resizable({
            grid: [grid_size + (grid_margin * 2), grid_size + (grid_margin * 2)],
            animate: false,
            minWidth: grid_size,
            minHeight: grid_size,
            containment: "#layouts_grid ul",
            autoHide: true,
            stop: function(event, ui) {
                var resized = $(this);
                setTimeout(function() {
                    resizeBlock(resized);
                }, 300);
            }
        });

        $('.gridster .remove').click(function(){
            $.post( '<?=Url::toRoute(['/content/front-grid/remove'])?>', {'id':$(this).data('id')}, function( data ) {
                $('#gridcontainer').html(data);
            });
        });

        $('#serialize').click(function(e){
            e.preventDefault();
            var data = gridster.serialize();
            var count = data.length;
            var th = 0;
            for(var i = 0; i < count; i++){
                $('#scmainpage-'+data[i].id+'-height').val(data[i].height);
                $('#scmainpage-'+data[i].id+'-x').val(data[i].x);
                $('#scmainpage-'+data[i].id+'-y').val(data[i].y);
                $('#scmainpage-'+data[i].id+'-width').val(data[i].width);
                th++;
            }

            $.post( $('#grid-form').attr('action'), $('#grid-form').serialize(), function( data ) {
                alert('Изменения сохранены');
            });
        });

        $(".ui-resizable-handle").hover(function() {
            gridster.disable();
        }, function() {
            gridster.enable();
        });

        function resizeBlock(elmObj) {

            var elmObj = $(elmObj);
            var w = elmObj.width() - grid_size;
            var h = elmObj.height() - grid_size;

            for (var grid_w = 1; w > 0; w -= (grid_size + (grid_margin * 2))) {

                grid_w++;
            }

            for (var grid_h = 1; h > 0; h -= (grid_size + (grid_margin * 2))) {

                grid_h++;
            }

            gridster.resize_widget(elmObj, grid_w, grid_h);
        }



    });


</script>