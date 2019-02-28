<?php

/* @var $model \common\models\SCProducts */

\frontend\assets\ProductAsset::register($this);

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\assets\ThumbProductAsset;

ThumbProductAsset::register($this);

/*$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description_ru,
]);*/

// ++ ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО
$name = trim($model->name_ru);
$this->registerMetaTag([
    'name' => 'description',
    'content' => "✔ Купить $name с быстрой доставкой по Москве ❤ Большой ассортимент и выгодные цены от $model->Price руб. ☎ Звоните 8 499 707-11-14 !",
]);
// -- ПРАВКИ МЕТАДАННЫХ ОТ СТЕФАНСКОГО

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model->meta_keywords_ru,
]);

if (isset($model->pictures[0])) {
    $this->registerMetaTag([
        'property' => 'og:image',
        'content' => 'http://rybalkashop.ru' . Yii::$app->imageman->load('/products_pictures/' . $model->pictures[0]->largest)
    ]);
}

$request = Yii::$app->request;

?>

<div data-title="<?= $this->title ?>" itemscope itemtype="http://schema.org/Product">
    <?= $this->render('_brandlink_mini', [
        'model' => $model->category
    ]) ?>

    <h2 class="title" itemprop="name"><?= $model->name_ru ?></h2>

    <?php if (Yii::$app->user->can('contentField')): ?>
        <?= $this->render('admin/__product_toolbar', [
            'model' => $model
        ]); ?>
    <?php endif; ?>

    <div class="rating">
        <div class="rat"></div>
    </div>

    <p class="product_code">Арт: <?= $model->product_code ?> </p>

    <div class="clearfix"></div>

    <div class="row description-card-good">
        <div class="col-md-6 col-sm-5 col-xs-12">
            <?php if ($model->canAdd == 1): ?>
                <?php $modelf = new \frontend\models\AddToCartForm;
                $form = ActiveForm::begin([
                    'id' => 'add-to-cart-form',
                    'action' => ['/shop/add-to-cart'],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                    'options' => [
                        'data-name' => $model->name_ru,
                        'class' => 'hidden-md hidden-lg'
                    ]
                ]) ?>

                <?= \yii\helpers\Html::activeHiddenInput($modelf, 'count', [
                    'value' => '1',
                    'id'    => 'addtocartform-count-main-'. $model->productID
                ]); ?>
                <?= \yii\helpers\Html::activeHiddenInput($modelf, 'product', [
                    'value' => $model->productID,
                    'id'    => 'addtocartform-product-main-'. $model->productID
                ]) ?>

                <button class="btn btn-primary btn-flat btn-block text-uppercase buybtn btn-rounded" type="submit">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> КУПИТЬ
                </button>
                <button class="btn btn-primary btn-flat btn-block buybtn" style="display: none" disabled="disabled" type="button">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                </button>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>

            <div class="left-information simages">
                <div class="img-wrapper">
                    <?php if (isset($model->pictures[0])): ?>
                        <a data-index="0" data-lightbox="productImages" data-size="1000x1000"
                           data-title="<?= $model->name_ru ?>" data-pjax="false"
                           href="<?= Yii::$app->imageman->load('/products_pictures/' . $model->pictures[0]->largest, '1000x1000', Yii::$app->settings->get('image', 'productEnlarged'), 'main', 'products') ?>">
                           <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $model->pictures[0]->largest, '400x400', Yii::$app->settings->get('image', 'productBig'), false, 'products'), ['alt' => $model->name_ru, 'id' => 'mainImage', 'itemprop' => 'image']) ?>
                        </a>
                    <?php else: ?>
                        <?= Html::img(Yii::$app->imageman->load('/onDesign.jpg', '400x400', Yii::$app->settings->get('image', 'productBig'), false, 'common'), ['alt' => $model->name_ru, 'id' => 'mainImage', 'itemprop' => 'image']) ?>
                    <?php endif; ?>
                </div>
                <div class="img-thumbs text-center">
                    <?php if (isset($model->pictures[1])): ?>
                        <?php foreach ($model->pictures as $k => $pic): ?>
                            <?php if ($k == 0) continue; ?>
                            <div class="col-sm-4 col-xs-4">
                                <a data-index="<?= $k ?>" data-lightbox="productImages" data-size="1000x1000"
                                   data-title="<?= $model->name_ru ?>" data-pjax="false"
                                   href="<?= Yii::$app->imageman->load('/products_pictures/' . $pic->largest, '1000x1000', Yii::$app->settings->get('image', 'productEnlarged'), 'main', 'products') ?>">
                                   <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $pic->filename, '120x120', Yii::$app->settings->get('image', 'productSmall'), false, 'products'), ['alt' => $model->name_ru, 'itemprop' => 'image']) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                <!-- Background of PhotoSwipe.
                     It's a separate element as animating opacity is faster than rgba(). -->
                <div class="pswp__bg"></div>

                <!-- Slides wrapper with overflow:hidden. -->
                <div class="pswp__scroll-wrap">
                    <!-- Container that holds slides.
                        PhotoSwipe keeps only 3 of them in the DOM to save memory.
                        Don't modify these 3 pswp__item elements, data is added later on. -->
                    <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                    </div>

                    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                    <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                            <!--  Controls are self-explanatory. Order can be changed. -->
                            <div class="pswp__counter"></div>
                            <button class="pswp__button pswp__button--close" title="Закрыть"></button>
                            <button class="pswp__button pswp__button--fs" title="Полный экран"></button>
                            <button class="pswp__button pswp__button--zoom" title="Приближение"></button>

                            <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                            <!-- element will get class pswp__preloader--active when preloader is running -->
                            <div class="pswp__preloader">
                                <div class="pswp__preloader__icn">
                                    <div class="pswp__preloader__cut">
                                        <div class="pswp__preloader__donut"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div>
                        </div>

                        <button class="pswp__button pswp__button--arrow--left" title="Предыдущая"></button>
                        <button class="pswp__button pswp__button--arrow--right" title="Следующая"></button>

                        <div class="pswp__caption">
                            <div class="pswp__caption__center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md hidden-lg"></div>

        <div class="col-md-6 col-sm-7">
            <div class="right-information" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <h3>Характеристики товара</h3>

                <?php $attrTarget = $model; ?>

                <?php if (empty($attrTarget->attrs)) {
                    $attrTarget = $model->canon;
                } ?>

                <?php if (!empty($attrTarget->attrs)): ?>
                    <?php foreach ($attrTarget->attrs as $attr): ?>
                        <?php if (empty($attr->option_value_ru)) continue; ?>
                        <div class="table-good">
                            <span><?= $attr->optionName; ?></span>
                            <strong><?= $attr->option_value_ru; ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?= $this->renderDynamic(
                    'return Yii::$app->view->render(\'//shop/category/product_views/parts/_dynamic/stock_string\');'
                );?>

                <?php if (!empty($model->stockString)): ?>
                    <div class="table-good presence">
                        <span><?= $model->stockString['label'] ?></span>
                        <strong class="text-red"><?= $model->stockString['value'] ?></strong>
                    </div>
                <?php endif; ?>

                <?php if (!empty($prependix)): ?>
                    <?= $this->render('addons/' . $prependix, [
                        'model' => $model
                    ]) ?>
                <?php endif; ?>

                <?= $this->renderDynamic(
                    'return Yii::$app->view->render(\'//shop/category/product_views/parts/_dynamic/price_buttons\');'
                ); ?>

                <div class="scrollToDescription">
                    <a class="btn btn-flat btn-info nowrap" href="#productDescription">
                        Описание <?= $model->category->name_ru ?> <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                    </a>
                </div>

                <?php if (!empty($appendix)): ?>
                    <?= $this->render('addons/' . $appendix, [
                        'model' => $model
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($model->description_ru)): ?>
            <div style="float: left; padding: 15px">
                <?= $model->description_ru ?>
            </div>
            <br/>
        <?php endif; ?>
    </div>
</div>

<?php

$js = <<< JS
$('.simages').each( function() {
        var \$pic     = $(this),
            getItems = function() {
                var items = [];
                \$pic.find('a').each(function() {
                    var \$href   = $(this).attr('href'),
                        \$size   = $(this).data('size').split('x'),
                        \$width  = \$size[0],
                        \$height = \$size[1];

                    var item = {
                        src : \$href,
                        w   : \$width,
                        h   : \$height
                    }

                    items.push(item);
                });
                return items;
            }

        var items = getItems();

        var \$pswp = $('.pswp')[0];
        \$pic.on('click', 'a', function(event) {
            event.preventDefault();

            var \$index = $(this).data('index');
            var options = {
                index: \$index,
                bgOpacity: 0.7,
                showHideOpacity: true
            }

            // Initialize PhotoSwipe
            var lightBox = new PhotoSwipe(\$pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
JS;
$this->registerJs($js);

if (!Yii::$app->user->isGuest) {
    $url = \yii\helpers\Url::to(['shop/subscribe-product']);
    $js = <<< JS
    $('#productContainer').on('click', '#send_subscription', function(e){
       id = $(this).data('id');
       item = $(this);
        $.ajax({
        type: "get",
        url: "$url",
        data: {id:id},
        success: function(data)
        {
            item.text("Вы ожидаете поступления");
            item.prop('disabled', true);
        }
    });
    });

    $('.products_table').on('click', '.towaiting', function(e){
        e.preventDefault();
        id = $(this).data('id');
        item = $(this);
        $.ajax({
            type: "get",
            url: "$url",
            data: {id:id},
            success: function(data)
            {
                item.text("Вы ожидаете поступления");
                item.removeClass('towaiting');
            }
        });
    });
JS;
$this->registerJs($js);
}

?>
