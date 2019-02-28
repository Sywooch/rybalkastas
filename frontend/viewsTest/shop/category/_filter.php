<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 17.03.2017
 * Time: 12:43
 */
$cache = Yii::$app->cache;

$key = 'category_filter_options_'.$model->categoryID;

$optQuery = $cache->get($key);

if ($optQuery === false) {
    $prdAr = \yii\helpers\ArrayHelper::getColumn($model->products, 'productID');
    $optQuery = \common\models\SCProductOptionsValues::find()
        ->joinWith('option', 'SC_product_options_values.optionID = SC_product_options.optionID')
        ->where(['in', 'productID', $prdAr])
        ->andWhere(['filter'=>1])
        ->groupBy('SC_product_options.optionID')
        ->all();
    $cache->set($key, $optQuery, 604800, new \yii\caching\TagDependency(['tags' => 'category_'.$model->categoryID]));
}

?>

<div class="box box-default box-solid">
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['category','id'=>$model->categoryID],
        'method' => 'get',
    ]); ?>
    <!-- /.box-header -->
    <div class="box-body" style="display: block;">
        <div class="col-md-12">
            <b>Цена:</b>
            <?=\yii\helpers\Html::activeTextInput($searchModel, 'price', ['id'=>'filterSlider', 'data-slider-id'=>'red', 'data-slider-min'=>$model->meta->minPrice,'data-slider-max'=>$model->meta->maxPrice, 'data-slider-step'=>5, 'data-slider-value'=>"[$searchModel->price]"]);?>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <?php
        $subcats = $cache->getOrSet(['category_monufacturers', $model->categoryID], function () use ($model) {
            return \common\models\SCCategories::findWithInner($model->categoryID)->groupBy('monufacturer')->all();
        }, 604800, new \yii\caching\TagDependency(['tags' => 'category_'.$model->categoryID]));

        $monufacturers = [];
        $tags = [];
        foreach($subcats as $m){
            $monufacturers[] = $m->monufacturer;
            $tags_in = explode(',',$m->tags);
            foreach ($tags_in as $t){
                $tags[] = trim($t);
            }
        }
        $monufacturers = array_unique($monufacturers);
        $tags = array_unique($tags);
        ?>
        <div class="col-md-6">
            <div class="form-group">
                <label>Производители</label>

                <?php
                $monsAr = [];
                foreach($monufacturers as $m){
                    $monsAr[$m] = $m;
                }?>

                <?=\yii\helpers\Html::activeDropDownList($searchModel, 'monufacturer', $monsAr, ['class'=>'form-control'])?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Особенности</label>
                <?php
                $tagsAr = [];
                foreach($tags as $t){
                    $tagsAr[$t] = $t;
                }?>


                <?=\yii\helpers\Html::activeDropDownList($searchModel, 'tags', $tagsAr, ['class'=>'form-control'])?>
            </div>
        </div>
        <div id="fltcontainer">
        <?php foreach ($optQuery as $opt){
            echo $this->render('filter_inputs/_'.$opt->option->filterType, ['option'=>$opt, 'searchModel'=>$searchModel]);
        }?>
        </div>
        <button class="btn btn-success btn-flat btn-block" type="submit">Показать</button>
    </div>
    <!-- /.box-body -->
    <?php \yii\widgets\ActiveForm::end();?>

</div>

<?php
$js = <<< JS
$('#filterSlider').slider({
	formatter: function(value) {
		return 'Цена от ' + value[0] + ' руб. до '+ value[1] + ' руб.';
	}
});

$('#fltcontainer input:checked').closest('.box-body').show().closest('.box').removeClass('collapsed-box').find('.fa').removeClass('fa-plus').addClass('fa-minus');;

JS;

$this->registerJs($js);?>