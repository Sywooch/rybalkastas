<div class="item col-md-3 col-xs-6">
    <div class="item-card">
        <?php $m=\common\models\SCCategories::findOne($l->categoryID);?>


        <?php
            if(empty($l->mon_marker)){
                $url = \yii\helpers\Url::to(['/shop/category', 'id'=>$m->categoryID]);
            } elseif(!empty($l->mon_marker) && $l->mon_marker <> 0){
                $key = str_replace(' ', '_', \common\models\SCMonufacturers::findOne($l->mon_marker)->name);
                $url = \yii\helpers\Url::to(['/shop/tagged', 'id'=>$m->categoryID, 'monufacturer'=>$key]);
            } else {
                $url = '#';
            }

        ?>


        <a href="<?=$url?>" class="name">
            <div class="img-wrap">
                <?php

                if(!empty($l->custom_image) && $l->custom_image <> ""){
                    $imagefile = $l->custom_image;
                } else {
                    $imagefile = $m->picture;
                }



                ?>
                <?= \yii\helpers\Html::img(Yii::$app->imageman->load('/products_pictures/'.$imagefile, '200x200', 80, false, (empty($l->custom_image)?'categories':'customcategories')), ['alt'=>$m->name_ru])?>
            </div>
            <div class="text-right equal-height-meta">
                <div class="minprice_label">
                    от <?=number_format($m->meta->minPrice,2)?> руб.
                </div>
            </div>
            <div class="card-label equal-height">
                <?=empty($l->custom_name)?$m->name_ru:$l->custom_name?>
            </div>
        </a>
    </div>
</div>