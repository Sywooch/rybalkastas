<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\url;
use kartik\widgets\Typeahead;
use yii\web\JsExpression;
use backend\assets\JuiAsset;
use backend\assets\NestedSortableAsset;

\yii\web\JqueryAsset::register($this);
NestedSortableAsset::register($this);
JuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SCCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
    .col-md-6{position: static!important;}
    .box{position: static!important;}
    .wrapper{position: static!important;}
</style>

<div class="sccategories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>

    </p>

    <div class="col-md-12">
        <?php
        $template = '<a href="{{link}}"><div><p class="repo-language">{{value}}</p>' .
            '<p class="repo-name"><b>{{type}}</b></p></div></a>';
        echo Typeahead::widget([
            'name' => 'everything',
            'options' => ['placeholder' => 'Поиск по названию категории, товара или коду'],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'prefetch' => Url::toRoute('/categories/ax'),
                    'remote' => [
                        'url' => Url::to(['/categories/ax']) . '?q=%QUERY',
                        'wildcard' => '%QUERY'
                    ],
                    'templates' => [
                        'notFound' => '<div class="text-danger" style="padding:0 8px">Нет совпадений.</div>',
                        'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                    ],
                    'limit' => 10
                ]
            ]
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">Категории</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="cattreemain">
                    <ul>
                        <?php echo $this->render('subtree', ['model'=>$model, 'static'=>1]);?>
                    </ul>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="col-md-6" style="position: relative;">
        <div class="box box-solid" style="
    overflow: auto;">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">Товары <span class="prdcatname"></span></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="prdtreemain">
                    <?php echo $this->render('products', ['products'=>$products, 'categoryID'=>$categoryID, 'static'=>1]);?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="clearfix"></div>

    <script>


        $(function(){

            checkFolders();

            $('.cattreemain').on("click", "li:not(.loaded) i", function () {
                $curli = $(this).parent();
                $curli.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
                $.ajax({
                    url: "<?=Url::toRoute('/categories/loadcats');?>",
                    type: "POST",
                    data: {'root':$curli.data('cat')},
                    success: function (response) {
                        $curli.addClass('loaded');
                        $curli.children('.preloader').remove();
                        $curli.append(response);
                        $curli.find('.catlist, hr').toggle(300);
                        checkFolders();
                    }
                });

            });

            $('.cattreemain').on("click", "li.loaded i", function () {
                $curli = $(this).parent();
                $curli.find('ul').toggle(300, function(){
                    $.ajax({
                        url: "<?=Url::toRoute('/categories/unloadcookie');?>",
                        type: "POST",
                        data: {'closed':$curli.data('cat')}
                    });
                    checkFolders();
                });

            });

            $('.cattreemain').on("click", "li span", function () {
                $curli = $(this).parent();
                $('.cattreemain li').removeClass('selected');
                $curli.addClass('selected');
                $prds = $('.prdtreemain');
                $prds.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
                $.ajax({
                    url: "<?=Url::toRoute('/categories/loadprds');?>",
                    type: "POST",
                    data: {'cat':$curli.data('cat')},
                    success: function (response) {
                        $prds.children('.preloader').remove();
                        $prds.find('.prdlist').hide(300, function(){
                            $prds.html(response);
                            $prds.find('.prdlist').show(300);
                        });

                    }
                });

            });

            $('.prdtreemain').on("mousedown", "li", function (e) {
                $('.prdtreemain li').removeClass('highlight');

                $item = $(this);
                $dd_id = $(this).parent().attr('id');
                console.log($dd_id);
                $('.prdlist div:not(#'+$dd_id+'-menu)').removeClass('open');
                if( e.button == 2 ) {
                    $(this).addClass('highlight');
                }
            });

            $('.cattreemain').on("mousedown", "li", function (e) {

                if( e.button == 2 ) {
                    $('.cattreemain li').removeClass('highlight');

                    $item = $(this);
                    $dd_id = $(this).parent().attr('id');
                    console.log($dd_id);
                    $('.catlist div:not(#'+$dd_id+'-menu)').removeClass('open');
                    $(this).addClass('highlight');
                }
            });

            $('.cattreemain').on('click', 'a:not(.deleteCat)', function(){
                window.location.href = $(this).attr('href');
            });



        });

        function checkFolders(){
            $('.cattreemain li').each(function(){
                $tocheck = $(this).find('ul');
                if($tocheck.is(':visible')){
                    if(!$(this).hasClass('loaded')){
                        $(this).addClass('loaded');
                    }
                    $(this).children('i').addClass('fa-folder-open');
                } else {
                    $(this).children('i').removeClass('fa-folder-open');
                }
            })
        }

        function resort(elem){
            elem.parent().children('li').each(function(){
                $.ajax({
                    url: "<?=Url::toRoute('/categories/set-sort')?>",
                    type: "POST",
                    data: {"id":$(this).data('cat'), "priority":$(this).index()},
                });
            })
        }

        function resortPrds(elem){
            elem.parent().children('li').each(function(){
                $.ajax({
                    url: "<?=Url::toRoute('/categories/set-sort-products')?>",
                    type: "POST",
                    data: {"id":$(this).data('cat'), "priority":$(this).index()},
                });
            })
        }


        function remCat(e, name, id, item) {
            e.preventDefault;
            var url = "<?=Url::toRoute(['/categories/deletecategory']);?>&id="+id;
            if (confirm("Удалить категорию "+name+"?")) {


                $.ajax({
                    url: url,
                    type: "POST",
                    data: {},
                    success: function(data){
                        item.closest("li").hide(200);
                    }
                });
            } else {
                return false;
            }
        }
    </script>
</div>

<style>
    .cattreemain ul:not(.dropdown-menu) > li {
        display: block;
        padding: 10px;
        margin-left: 5px;
        background: #fff;
        border: solid 1px #ECF0F5;
        cursor: pointer;
        position: static;
    }

    .cattreemain i {
        margin-right: 10px;
        float: left;
        font-size: 142%;
    }

    .cattreemain span{
        display: block;
    }

    .cattreemain ul{
        padding:0;
        position: static;
    }

    .prdtreemain {
        position: relative;
    }
    .prdtreemain ul:not(.dropdown-menu) > li {
        display: block;
        padding: 10px;
        margin-left: 5px;
        background: #fff;
        border: solid 1px #ECF0F5;
        cursor: pointer;
        position: relative;
    }

    .prdtreemain li.highlight {
        background: #C9CBFF;
    }

    .cattreemain li.highlight {
        background: #c1ffd3;
    }

    .prdtreemain i {
        margin-right: 10px;
    }

    .prdtreemain ul{
        padding:0;
    }

    .preloader {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        background-color: rgba(139, 139, 139, 0.58);
    }

    .preloader i {
        line-height: 40px;
    }

    .cattreemain ul:not(.dropdown-menu) > div > li.selected {
        background-color: #D8DBFF;
    }

    li.appended {
        color: #4A7D3D;
    }
</style>
