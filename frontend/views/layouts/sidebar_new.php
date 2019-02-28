<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\SCCategories;
use common\models\SCProductOptionsValues;

$cache = Yii::$app->cache;

$modelM = \common\models\SCCategories::find()
       ->where(['parent' => 1])
    ->andWhere('hidden <> 1')
     ->orderBy('sort_order ASC')
         ->all();

$key = 'category_filter_3_options_' . $model->categoryID;

//\yii\caching\TagDependency::invalidate(Yii::$app->cache, 'category_'.$model->categoryID);

$prdAr = ArrayHelper::getColumn($model->products, 'productID');

$optQuery = SCProductOptionsValues::find()
    ->joinWith('option', 'SC_product_options_values.optionID = SC_product_options.optionID')
       ->where(['in', 'productID', $prdAr])
    ->andWhere(['filter' => 1])
     ->groupBy('SC_product_options.optionID');

$optQuery = $optQuery->all();

$items = [];

$modelAction = SCCategories::getDb()->cache(function ($db) {
    return SCCategories::find()
           ->where(['parent' => 1])
        ->andWhere('hidden <> 1')
        ->andWhere('JSON_EXTRACT(meta_data, "$.hasAction") = 1')
        ->andWhere('JSON_EXTRACT(meta_data, "$.countActionInStock") > 0')
         ->orderBy('sort_order ASC')
             ->all();
});

$actionItems = [];

foreach ($modelAction as $m) {
    $actionItems[] = [
        'label' => '<i class="fa fa-percent text-warning" aria-hidden="true"></i> ' . $m->name_ru,
        'url' => Url::to(['/shop/actions', 'id' => $m->categoryID])
    ];
}

$items[] = [
    'label' => '<img src="/img/icons/discount.svg" style="width: 50px" > Распродажа',
    'url' => ['/shop/actions'],
    'items' => $actionItems,
    'options' => [
        'class' => 'dropdown-submenu'
    ]
];

foreach ($modelM as $m) {
    $menuitem = [];

    $label = '<div class="img-wrap">' . Html::img(Yii::$app->imageman->load('/products_pictures/' . $m->menupicture, '50x50', Yii::$app->settings->get('image', 'sidebarcat'), false, 'sidebar'), ['alt' => $m->name_ru]) . '</div>' . $m->name_ru;

    $menuitem['label'] = $label;

    $menuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id' => $m->categoryID]);

    if ($m->showsubmenu == 1) {
        $menuitem['options'] = ['class' => 'dropdown-submenu'];

        $menuitem['items'] = [];

        $cache = Yii::$app->cache;

        $key = 'sidemenu_inner_' . $m->categoryID;

        $query = $cache->getOrSet($key, function () use ($m) {
            return (new \yii\db\Query())
                 ->select('*')
                   ->from([\common\models\SCCategories::findWithParents($m->categoryID)])
                ->orderBy('sort_order ASC')->all();
        });

        $submenuitem = [];

        $submenuitem['label'] = '<i class="fa fa-chevron-right"></i> Основной раздел';

        $submenuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id' => $m['categoryID']]);

        $menuitem['items'][] = $submenuitem;

        foreach ($query as $cat) {
            $submenuitem = [];

            $submenuitem['label'] = '<i class="fa fa-chevron-right"></i> ' . $cat['name_ru'];

            $submenuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id' => $cat['categoryID']]);

            $menuitem['items'][] = $submenuitem;
        }
    }

    $items[] = $menuitem;
}

/*$subcats = $cache->getOrSet(['category_monufacturers', $model->categoryID], function () use ($model) {
    return \common\models\SCCategories::findWithInner($model->categoryID, false)->groupBy('monufacturer')->all();
}, 604800, new \yii\caching\TagDependency(['tags' => 'category_' . $model->categoryID]));*/

$subcats = \common\models\SCCategories::getDb()->cache(function ($db)  use ($model){
    return \common\models\SCCategories::findWithInner($model->categoryID)->all();
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

$tags = []; // TODO: ВЕРНУТЬ ТЕГИ КОГДА БУДУТ ГОТОВЫ

?>

<?php $form = ActiveForm::begin([
    'action' => Url::current(),
    'method' => 'get',
]); ?>

    <div class="dropdown catalog-dd <?php if(!empty($_GET['SCCategoriesSearch']))echo 'open'?>">
        <button class="btn btn-primary btn-lg btn-flat btn-block dropdown-toggle text-uppercase" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-bars" aria-hidden="true"></i> Фильтр<span class="caret"></span>
        </button>

        <ul class="dropdown-menu" id="filterdropdownmenu" aria-labelledby="dropdownMenu1">
            <li>
                <div class="col-xs-12">
                    <b>Цена <i class="fa fa-ruble"></i>:</b>
                    <div class="form-group">
                        <div class="input-group slider-with-input">
                            <?php $filterPrice = $searchModel->price;
                            if (empty($filterPrice)) {
                                $filterPrice = $model->meta->minPrice.','.$model->meta->maxPrice;
                            } ?>

                            <?= \yii\helpers\Html::activeTextInput($searchModel, 'price', [
                                'id' => 'filterSlider',
                                'data-slider-id' => 'red',
                                'data-slider-min' => $model->meta->minPrice,
                                'data-slider-max' => $model->meta->maxPrice,
                                'data-slider-step' => 5,
                                'data-slider-value' => "[$filterPrice]"
                            ]); ?>
                        </div>
                        <div class="slider-input-line">
                            <span class="slider-input-left">
                                <input type="text" class="form-control">
                            </span>
                            <span class="slider-input-right">
                                <input type="text" class="form-control">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
            <li>
                <div class="col-xs-12">
                    <?=Html::hiddenInput('onlyAvailable', 0)?>
                    <label><?= \yii\helpers\Html::checkbox('onlyAvailable', (isset($_GET['onlyAvailable']) && $_GET['onlyAvailable'] == 1)) ?> Только в наличии</label>
                </div>
            </li>
            <li>
                <div class="col-xs-12">
                    <?=Html::hiddenInput('onlyActions', 0)?>
                    <label><?= \yii\helpers\Html::checkbox('onlyActions', $searchModel->onlyActions == 1) ?> Только акции</label>
                </div>
            </li>

            <?php if(count(array_filter($tags)) > 1  && !empty($_POST['tags'])):?>
            <li>
                <div class="col-xs-12">
                    <label class="filterhead">Особенности</label>
                    <div class="checkboxes" style="display: none">
                        <div class="form-group">
                            <?php $tagsAr = [];
                            foreach ($tags as $t) {
                                $tagsAr[$t] = ucfirst($t);
                            }
                            $tagsAr = array_filter($tagsAr); ?>

                            <?= \yii\helpers\Html::activeCheckboxList($searchModel, 'tags', $tagsAr) ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
            <?php endif;?>

            <?php if(count(array_filter($monufacturers)) > 1  && !empty($_POST['monfucaturer'])):?>
            <li>
                <div class="col-xs-12">
                    <label class="filterhead"><i class="fa fa-caret-right" aria-hidden="true"></i><i class="fa fa-caret-down" style="display: none" aria-hidden="true"></i> Производитель</label>
                    <div class="checkboxes" style="display: none">
                        <div class="form-group">
                            <?php $monsAr = [];
                            foreach ($monufacturers as $m) {
                                $monsAr[$m] = $m;
                            }
                            $monsAr = array_filter($monsAr); ?>

                            <?= \yii\helpers\Html::activeCheckboxList($searchModel, 'monufacturer', $monsAr) ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
            <?php endif;?>

            <?php foreach ($optQuery as $opt): ?>
                <?php switch ($opt->option->name_ru){
                    case 'RUSIZE':
                        $optname = "Размер";
                        break;
                    default:
                        $optname = $opt->option->name_ru;
                        break;
                } ?>
                <li>
                    <div class="col-xs-12">
                        <label class="filterhead"><i class="fa fa-caret-right" aria-hidden="true"></i><i class="fa fa-caret-down" style="display: none" aria-hidden="true"></i> <?= $optname ?></label>
                        <div class="checkboxes" style="display: none">
                            <?= $this->render('filter_inputs/_' . $opt->option->filterType, ['option' => $opt, 'searchModel' => $searchModel, 'model'=>$model]); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </li>
            <?php endforeach; ?>

            <div class="col-xs-12">
                <hr>
                <?php if(!empty($_GET['SCCategoriesSearch'])):?>
                    <a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$model->categoryID])?>" class="btn btn-danger btn-flat btn-block">Сбросить</a>
                <?php endif;?>
                <button type="submit" class="btn btn-success btn-flat btn-block">Применить</button>
            </div>
        </ul>
        <div class="clearfix"></div>
    </div>

<?php \yii\widgets\ActiveForm::end();?>

    <div class="sidebar-good">
        <?= \yii\widgets\Menu::widget([
            'items' => $items,
            'activateParents' => true,
            'submenuTemplate' => "\n<ul class='dropdown-menu'>\n{items}\n</ul>\n",
            'encodeLabels' => false,
            'options' => [
                'class' => 'type-good'
            ],
        ]); ?>
    </div>

    <div class="clearfix"></div>

    <ul class="brand top10 ">
        <?php foreach (\common\models\SCSidebarbrands::find()->orderBy('order ASC')->all() as $brand): ?>
            <li>
                <a href="<?= $brand->link ?>"><?= Html::img(Yii::$app->imageman->load('/brandlogos/JPEG/' . $brand->picture, '180x96', Yii::$app->settings->get('image', 'sidebarbrand'), false, 'sidebarbrands'), ['alt' => $brand->text]) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="news-sidebar hidden-xs">
        <div class="wrapper">
            <h4>Новости</h4>
            <a href="<?= \yii\helpers\Url::to(['/news/index']) ?>" class="look-all">Смотреть все</a>
        </div>

        <?php foreach (\common\models\SCNewsTable::find()->where(['published'=>1])->orderBy('NID DESC')->limit(5)->all() as $n): ?>
            <div class="item-card">
                <?= Html::img(Yii::$app->imageman->load('/news_pictures/' . $n->image, '162x164', Yii::$app->settings->get('image', 'sidebarnews'), false, 'sidebarnews'), ['alt' => $n->title_ru]) ?>
                <div class="date"><?= Yii::$app->formatter->asRelativeTime(strtotime($n->add_date)); ?></div>
                <h2><?= $n->title_ru ?></h2>
                <a href="<?= \yii\helpers\Url::to(['/news/item', 'id' => $n->NID]) ?>"></a>
            </div>
        <?php endforeach; ?>
    </div>

<?php $js = <<< JS
$('.catalog-dd').stick_in_parent({parent:'.sidebar'});

$('.filterhead').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    $(this).find('i').toggle();
    $(this).next('.checkboxes').slideToggle();
});

$('#filterdropdownmenu *').click(function(e){
    e.stopPropagation();
});

$('#filterSlider').slider({
	formatter: function(value) {
		return 'Цена от ' + value[0] + ' руб. до '+ value[1] + ' руб.';
	}
});
$('#filterSlider').sliderTextInput();

$('#fltcontainer input:checked').closest('.box-body').show().closest('.box').removeClass('collapsed-box').find('.fa').removeClass('fa-plus').addClass('fa-minus');
$('.checkboxes input:checked').closest('.checkboxes').show();
$('.checkboxes input:checked').closest('.checkboxes').prev('.filterhead').find('i').toggle();
JS;
$this->registerJs($js);
