<?php
use yii\helpers\Html;
use common\models\SCCategories;

$modelM = \common\models\SCCategories::find()->where(['parent' => 1])->andWhere('hidden <> 1')->orderBy('sort_order ASC')->all();
$cache = Yii::$app->cache;

$key = 'category_filter_options_' . $model->categoryID;

$optQuery = $cache->get($key);

if ($optQuery === false) {
    $prdAr = \yii\helpers\ArrayHelper::getColumn($model->products, 'productID');
    $optQuery = \common\models\SCProductOptionsValues::find()
        ->joinWith('option', 'SC_product_options_values.optionID = SC_product_options.optionID')
        ->where(['in', 'productID', $prdAr])
        ->andWhere(['filter' => 1])
        ->groupBy('SC_product_options.optionID')
        ->all();
    $cache->set($key, $optQuery, 604800, new \yii\caching\TagDependency(['tags' => 'category_' . $model->categoryID]));
}
?>


<div class="dropdown catalog-dd">
    <button class="btn btn-primary btn-lg btn-flat btn-block dropdown-toggle text-uppercase" type="button" id="dropdownMenu1"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="fa fa-bars" aria-hidden="true"></i> Каталог
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php foreach ($modelM as $m): ?>
            <li class="dropdown-submenu">

                <a href="<?= \yii\helpers\Url::to(['/shop/category', 'id' => $m->categoryID]) ?>">
                    <div class="img-wrap">
                        <?= Html::img(Yii::$app->imageman->load('/products_pictures/'.$m->menupicture, '50x50', Yii::$app->settings->get('image', 'sidebarcat'), false, 'sidebar'), ['alt'=>$m->name_ru])?>

                    </div>
                    <?= $m->name_ru ?></a>
                <?php if ($m->showsubmenu == 1): ?>
                    <ul class="dropdown-menu">
                        <?php
                        $cache = Yii::$app->cache;
                        $key = 'sidemenu_inner_' . $m->categoryID;
                        $query = $cache->getOrSet($key, function () use ($m) {
                            return (new \yii\db\Query())
                                ->select('*')
                                ->from([\common\models\SCCategories::findWithParents($m->categoryID)])
                                ->orderBy('sort_order ASC')->all();
                        });

                        ?>
                        <li><a href="<?= \yii\helpers\Url::to(['/shop/category', 'id' => $m->categoryID]) ?>"><i
                                        class="fa fa-chevron-right"></i> Основной раздел</a></li>

                        <?php foreach ($query as $cat): ?>
                            <li><a href="<?= \yii\helpers\Url::to(['/shop/category', 'id' => $cat['categoryID']]) ?>"><i
                                            class="fa fa-chevron-right"></i> <?= $cat['name_ru'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="filterside col-md-12 top10">
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['category','id'=>$model->categoryID],
        'method' => 'get',
    ]); ?>
    <h5>Фильтр</h5>
    <hr>
    <div class="">
        <b>Цена:</b>
        <?= \yii\helpers\Html::activeTextInput($searchModel, 'price',
            [
                'id' => 'filterSlider',
                'data-slider-id' => 'red',
                'data-slider-min' => $model->meta->minPrice,
                'data-slider-max' => $model->meta->maxPrice,
                'data-slider-step' => 5,
                'data-slider-value' => "[$searchModel->price]"]); ?>
    </div>
    <?php
    /*$subcats = $cache->getOrSet(['category_monufacturers', $model->categoryID], function () use ($model) {
        return \common\models\SCCategories::findWithInner($model->categoryID, false)->groupBy('monufacturer')->all();
    }, 604800, new \yii\caching\TagDependency(['tags' => 'category_' . $model->categoryID]));*/


    $subcats = \common\models\SCCategories::getDb()->cache(function ($db)  use ($model){
        return \common\models\SCCategories::findWithInner($model->categoryID, false)->groupBy('monufacturer')->all();
    });


    $monufacturers = [];
    $tags = [];
    foreach ($subcats as $m) {
        $monufacturers[] = $m->monufacturer;
        $tags_in = explode(',', $m->tags);
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
    <div class="checkboxes">
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
    <div id="fltcontainer_sidebar">

        <?php foreach ($optQuery as $opt): ?>
            <hr>
            <label class="filterhead"><?= $opt->option->name_ru ?></label>
            <div class="checkboxes" style="display: none">
                <?= $this->render('filter_inputs/_' . $opt->option->filterType, ['option' => $opt, 'searchModel' => $searchModel]); ?>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
    <hr>
    <?php if(!empty($_GET['SCCategoriesSearch'])):?>
    <a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$model->categoryID])?>" class="btn btn-danger btn-flat btn-block">Сбросить</a>
    <?php endif;?>
    <button type="submit" class="btn btn-success btn-flat btn-block">Применить</button>
    <?php \yii\widgets\ActiveForm::end();?>
    <hr>
</div>
<div class="clearfix"></div>
    <ul class="brand top10 ">
        <?php foreach(\common\models\SCSidebarbrands::find()->orderBy('order ASC')->all() as $brand):?>
            <li><a href="<?=$brand->link?>"><?= Html::img(Yii::$app->imageman->load('/brandlogos/JPEG/'.$brand->picture, '180x96', Yii::$app->settings->get('image', 'sidebarbrand'), false, 'sidebarbrands'), ['alt'=>$brand->text])?></a></li>
        <?php endforeach;?>
    </ul>
    <div class="news-sidebar hidden-xs">
        <div class="wrapper">
            <h4>Новости</h4>
            <a href="<?=\yii\helpers\Url::to(['/news/index'])?>" class="look-all">Смотреть все</a>
        </div>
        <?php foreach(\common\models\SCNewsTable::find()->orderBy('NID DESC')->limit(5)->all() as $n):?>
            <div class="item-card">
                <?= Html::img(Yii::$app->imageman->load('/news_pictures/'.$n->image, '162x164', Yii::$app->settings->get('image', 'sidebarnews'), false, 'sidebarnews'), ['alt'=>$n->title_ru])?>
                <div class="date"><?=Yii::$app->formatter->asRelativeTime(strtotime($n->add_date));?></div>
                <h2><?=$n->title_ru?></h2>
                <a href="<?=\yii\helpers\Url::to(['/news/item', 'id'=>$n->NID])?>"></a>
            </div>
        <?php endforeach;?>
    </div>
<?php $js = <<< JS
$('.filterhead').click(function(){
    $(this).next('.checkboxes').slideToggle();
});
$('#filterSlider').slider({
	formatter: function(value) {
		return 'Цена от ' + value[0] + ' руб. до '+ value[1] + ' руб.';
	}
});

$('#fltcontainer input:checked').closest('.box-body').show().closest('.box').removeClass('collapsed-box').find('.fa').removeClass('fa-plus').addClass('fa-minus');




JS;
$this->registerJs($js);
