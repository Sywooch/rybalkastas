<?php
use frontend\assets\FrontAsset;

FrontAsset::register($this);
$model = \common\models\SCMainpage::find()->all();
?>


<div class="banner-holder hidden-xs hidden-sm">
    <ul>

        <?php foreach ($model as $m): ?>
            <li data-row="<?=$m->y;?>" data-col="<?=$m->x;?>" data-sizex="<?=$m->width;?>" data-sizey="<?=$m->height;?>" style="background-image:url('/img/mainpage/start/<?=$m->picture;?>'); background-size:100% 100%;">
                <a href="<?=$m->url;?>"></a>
            </li>
        <?php endforeach; ?>

    </ul>

</div>

<?php
$js = <<< JS
var grid_size = 100;
        var grid_margin = 10;
        var block_params = {
            max_width: 6,
            max_height: 6
        };
        
$(".banner-holder ul").gridster({
        widget_margins: [grid_margin, grid_margin],
        widget_base_dimensions: [grid_size, grid_size],
        draggable:false,
        autogenerate_stylesheet: true,
    }).data('gridster').disable();;
JS;
$this->registerJs($js);
?>