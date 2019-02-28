<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\Menu;
use kartik\alert\AlertBlock;
use frontend\assets\AppAsset;
use frontend\assets\ChristmasAsset;
use common\models\SCCategories;
use common\widgets\Alert;

AppAsset::register($this);
ChristmasAsset::register($this);

$fixKey = "";

$model = \common\models\SCCategories::find()
       ->where(['parent' => 1])
    ->andWhere('hidden <> 1')
     ->orderBy('sort_order ASC')
         ->all();

$items = [];

foreach ($model as $m) {
    $menuitem = [];

    $label = '<div class="img-wrap">' . Html::img(
            Yii::$app->imageman->load('/products_pictures/' . $m->menupicture, '50x50', Yii::$app->settings->get('image', 'sidebarcat'), false, 'sidebar'), ['alt' => $m->name_ru]
        ) . '</div>' . $m->name_ru;

    $menuitem['label'] = $label;
    $menuitem['url'] = \yii\helpers\Url::to(['/shop/category', 'id' => $m->categoryID]);

    $items[] = $menuitem;
} ?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="TbmCNe__fWkoHMcleTVXLjk5oNk_bE_UzZAe8UzFmVk" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="mobile-bg"></div>
<div id="snowfall"></div>
<?= $this->renderDynamic('return Yii::$app->view->render(\'//_admin_blocks/_main_toolbar\');'); ?>
<?php if (Yii::$app->session->hasFlash('notify') && !empty(Yii::$app->session->getFlash('notify')['msg'])) {
    $msg = Yii::$app->session->getFlash('notify')['msg'];
    $icon = Yii::$app->session->getFlash('notify')['icon'];

$js = <<< JS
var myToast = new ax5.ui.toast({
        icon: '<i class="fa $icon"></i>',
        containerPosition: "top-right",
        closeIcon: '<i class="fa fa-times"></i>',
        "displayTime":5000,
    });
    myToast.push("$msg");
JS;
$this->registerJs($js);
} ?>

<div class="main-wrap">
    <header>
        <div class="container top">
            <div id="cartInformer">
                <?= $this->renderDynamic('return Yii::$app->view->render(\'//_blocks/_cart_informer\');'); ?>
            </div>
            <div class="row overflow_show">
                <div class="col-sm-5 col-md-5 col-xs-6 col-lg-6">
                    <strong class="logo"><a href="/"><img src="/img/logo.png" alt=""></a></strong>
                </div>
                <div class="col-xs-6 contact visible-xs">
                    <span>с 10:00 до 22:00 ежедневно</span>
                    <a href="tel:+ 7 (499) 707-11-14"><strong>+ 7 (499) 707-11-14</strong></a>
                </div>
                <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
                <div class="col-sm-7 col-md-7 col-lg-6">
                    <div class="right-panel-header">
                        <div class="row overflow_show flex_center">
                            <div class="col-sm-12 col-md-6 hidden-xs contact">
                                <span>с 10:00 до 22:00 ежедневно</span>
                                <a href="tel:+ 7 (499) 707-11-14"> <strong>+ 7 (499) 707-11-14</strong></a>
                                <?= $this->render('_phones_modal') ?>
                            </div>
                            <div class="col-sm-12 col-md-6 apply">
                                <?php $form = \yii\widgets\ActiveForm::begin([
                                    'action' => ['/shop/search'],
                                    'method' => 'get',
                                ]); ?>
                                <div class="input-group mainsearch">

                                    <?= \yii\helpers\Html::activeTextInput(new \common\models\SCCategoriesSearchMicro(), 'search_s', ['class' => 'form-control', 'placeholder' => 'Поиск']); ?>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php \yii\widgets\ActiveForm::end(); ?>
                                <?= $this->renderDynamic('return Yii::$app->view->render(\'//layouts/_login_block\');'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="mobile-panel">
                    <span>МЕНЮ</span>
                    <button type="button" class="navbar-toggle-button">
                        <span class="sr-only">Показать меню</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="basket">
                        <a href="<?= Url::to(['/cart/index']) ?>"><i class="fa fa-shopping-cart"></i></a>
                    </div>
                </div>
                <nav class="mnav">
                    <?= \yii\widgets\Menu::widget([
                        'items' => [
                            // Important: you need to specify url as 'controller/action',
                            // not just as 'controller' even if default action is used.
                            ['label' => 'Главная', 'url' => ['/site/index']],
                            ['label' => 'Каталог <b class="caret"></b>', 'url' => '#', 'options' => ['class' => 'hidden-lg hidden-md hide-backdrop'], 'template' => '<a href="{url}" data-toggle="dropdown">{label}</a>', 'items' => $items],
                            ['label' => 'О компании', 'url' => ['/page/index', 'slug' => 'o-nas']],
                            ['label' => 'Новости', 'url' => ['/news/index']],
                            ['label' => 'Консультация', 'url' => ['/experts/index']],
                            ['label' => 'Как купить', 'url' => ['/page/index', 'slug' => 'kak-zakazat']],
                            ['label' => 'Доставка', 'url' => ['/page/index', 'slug' => 'dostavka']],
                            ['label' => 'Оплата', 'url' => ['/page/index', 'slug' => 'sposoby-oplaty']],
                            ['label' => 'Скидки и акции', 'url' => ['/page/index', 'slug' => 'skidki-i-akcii']],
                            ['label' => 'Контакты', 'url' => ['/page/shops']],
                            ['label' => 'Отзывы', 'url' => ['/review/index']],
                            // 'Products' menu item will be selected as long as the route is 'product/index'
                        ],
                        'submenuTemplate' => "\n<ul id=\"catalogSubmenu\" class='dropdown-menu'>\n{items}\n</ul>\n",
                        'encodeLabels' => false,
                    ]); ?>
                </nav>
            </div>
        </div>
    </header>
    <?php //echo $this->render('//_blocks/_revo_slider'); ?>
    <section class="main-content">
        <div class="container">
            <div class="row" id="main_row">
                <?php if (!isset($this->params['hide_sidebar'])): ?>
                    <div class="col-md-3 sidebar">
                        <?php if (!empty($this->params['filter'])): ?>
                            <?= $this->render('sidebar_new', ['model' => $this->params['model'], 'searchModel' => $this->params['searchModel']]); ?>
                        <?php else: ?>
                            <?= $this->render('sidebar'); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="<?php if (isset($this->params['hide_sidebar'])): ?>col-md-12 full-panel<?php else: ?>col-md-9 right-panel<?php endif; ?>">
                    <div class="right-panel-holder">
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]); ?>

                        <?= AlertBlock::widget([
                            'type'            => AlertBlock::TYPE_ALERT,
                            'useSessionFlash' => true
                        ]); ?>

                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->render('_footer'); ?>
    <?= $this->render('_scroller'); ?>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter25789859 = new Ya.Metrika({
                    id: 25789859,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
                //
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/25789859" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<div class="backdrop"></div>

<?php if (!Yii::$app->user->isGuest && !isset($_COOKIE['requestedCookieShow_n2'])): ?>
    <?php $count = Yii::$app->user->identity->customer->requestedCount;
    if ($count > 0) {
        $msg = Yii::$app->i18n->format('В наличие {n, plural, =0{поступило} =1{поступила} one{поступила} few{поступило} many{поступило} other{поступило}} {n, plural, =0{0 позиций} =1{одна позиция} one{1 позиция} few{# позиций} many{# позиций} other{# позиции}} из Вашего списка ожидаемых товаров!', ['n' => $count], 'ru_RU');
$js = <<< JS
$.toast({
    heading: 'Ожидаемые товары',
        text: '$msg <br/> <a href="/user/settings/requestedproducts">Перейти к списку</a>',
        showHideTransition: 'fade',
        icon: 'success',
        position: 'top-right',
        stack: false,
        bgColor: '#af0000',
        hideAfter: 10000,
    })
JS;
$this->registerJs($js);
} ?>
<?php endif; ?>

<?php $js = <<< JS
$(function(){
    $(".basket").popover({
        html : true,
        content: function() {
          var content = $(this).attr("data-popover-content");
          return $(content).children(".popover-body").html();
        },
        title: function() {
          var title = $(this).attr("data-popover-content");
          return $(title).children(".popover-heading").html();
        },
        container: 'body'
    }).click(function(e){
        $('.cart_table').slimScroll({
            height: '250px'
        });
    });
    
});
JS;
$this->registerJs($js);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
