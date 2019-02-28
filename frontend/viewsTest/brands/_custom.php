<div class="item col-md-3 col-xs-6">
    <div class="item-card">
        <a href="<?=$l->custom_link?>" class="name">
            <div class="img-wrap">
                <?php

                if(!empty($l->custom_image) && $l->custom_image <> ""){
                    $imagefile = $l->custom_image;
                } else {
                    $imagefile = $l->picture;
                }



                ?>
                <?= \yii\helpers\Html::img(Yii::$app->imageman->load('/products_pictures/'.$imagefile, '200x200', 80, false, (empty($l->custom_image)?'categories':'customcategories')), ['alt'=>$l->custom_name])?>
            </div>

            <div class="card-label equal-height">
                <?=$l->custom_name?>
            </div>
        </a>
    </div>
</div>