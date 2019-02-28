<?php
use frontend\assets\RevolutionAsset;
use common\models\SCSlider1;
RevolutionAsset::register($this);

$slides = SCSlider1::find()->where(['disabled'=>0])->orderBy('sort_order ASC')->all();


?>

<div id="main-slider" class="owl-carousel owl-theme">
    <?php foreach($slides as $sld):?>
        <div class="item">
            <?php if(!empty($sld->url)):?><a href="<?=$sld->url?>"><?php endif;?>
            <img src="/img/slider/<?=$sld->image;?>"/>
            <?php if(!empty($sld->url)):?></a><?php endif;?>
        </div>
    <?php endforeach;?>
</div>
