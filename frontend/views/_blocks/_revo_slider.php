<?php
use frontend\assets\RevolutionAsset;
use common\models\SCSlider1;
RevolutionAsset::register($this);

$slides = SCSlider1::find()->where(['disabled'=>0])->orderBy('sort_order ASC')->all();
?>
<div class="container">
    <div class="row">
        <div class="slider-container rev_slider_wrapper">
            <div id="revolutionSlider" class="slider rev_slider">
                <ul>
                    <?php foreach($slides as $s):?>
                        <li data-transition="fade">
                            <img src="/img/slider/<?=$s->image?>"
                                 alt=""
                                 data-bgposition="center center"
                                 data-bgfit="cover"
                                 data-bgrepeat="no-repeat"
                                 class="rev-slidebg"/>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

</div>


<div class="clearfix"></div>

