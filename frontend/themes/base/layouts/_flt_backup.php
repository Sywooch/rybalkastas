<?php
/*$subcats = $cache->getOrSet(['category_monufacturers', $model->categoryID], function () use ($model) {
    return \common\models\SCCategories::findWithInner($model->categoryID, false)->groupBy('monufacturer')->all();
}, 604800, new \yii\caching\TagDependency(['tags' => 'category_' . $model->categoryID]));*/


$subcats = \common\models\SCCategories::getDb()->cache(function ($db)  use ($model){
    return \common\models\SCCategories::findWithInner($model->categoryID, false)->all();
});


$monufacturers = [];
$tags = [];
foreach ($subcats as $m) {
    $monufacturers[] = $m->monufacturer;
    if(strpos($m->tags, ',') !== false){
        $tags_in = explode(',', $m->tags);
    } else {
        $tags_in[] = $m->tags;
    }
    foreach ($tags_in as $t) {
        $tags[] = trim($t);
    }
}
$monufacturers = array_unique($monufacturers);
$tags = array_unique($tags);
?>

<?php if(count(array_filter($tags)) > 1):?>
    <label class="filterhead">Особенности</label>
    <div class="checkboxes">
        <div class="form-group">
            <?php
            $tagsAr = [];
            foreach ($tags as $t) {
                $tagsAr[$t] = ucfirst($t);
            }
            $tagsAr = array_filter($tagsAr);

            ?>


            <?= \yii\helpers\Html::activeCheckboxList($searchModel, 'tags', $tagsAr) ?>
        </div>
    </div>
    <hr>
<?php endif;?>
<?php if(count(array_filter($monufacturers)) > 1):?>
    <label class="filterhead">Производитель</label>
    <div class="checkboxes" style="display: none">
        <div class="form-group">

            <?php
            $monsAr = [];
            foreach ($monufacturers as $m) {
                $monsAr[$m] = $m;
            }
            $monsAr = array_filter($monsAr);
            ?>

            <?= \yii\helpers\Html::activeCheckboxList($searchModel, 'monufacturer', $monsAr) ?>

        </div>
    </div>
<?php endif;?>