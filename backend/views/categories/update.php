<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\SCCategories */

$this->title = 'Обновить категорию: ' . ' ' . $model->name_ru;

$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_ru, 'url' => ['view', 'id' => $model->categoryID]];
$this->params['breadcrumbs'][] = 'Изменить';

?>

<div class="sccategories-update">
    <?= $this->render('_form', [
        'model' => $model,
        'rootCats'=> $rootCats,
        'main' => $main,
        'nearCats' => $nearCats,
    ]) ?>
</div>

<script>
    $(function(){
        $('.cattreemain').on("click", "li:not(.loaded) i", function () {
            $curli = $(this).parent();

            $curli.append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');

            $.ajax({
                url: "<?= Url::toRoute('/categories/loadsubcatsajax'); ?>",
                type: "POST",
                data: {
                    'root': $curli.data('cat'),
                    'type': $curli.data('type'),
                    'template': $curli.closest('.cattreemain').data('template'),
                    'main': <?= $main; ?>,
                },
                success: function (response) {
                    $curli.addClass('loaded');
                    $curli.children('.preloader').remove();
                    $curli.append(response);
                    $curli.find('.catlist').toggle(300);
                    checkFolders();
                }
            });

        });

        $('.cattreemain').on("click", "li.loaded i", function () {
            $curli = $(this).parent();

            $curli.find('ul').toggle(300, function(){
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
                url: "<?= Url::toRoute('/categories/loadprds'); ?>",
                type: "POST",
                data: {
                    'cat': $curli.data('cat')
                },
                success: function (response) {
                    $prds.children('.preloader').remove();
                    $prds.find('.prdlist').hide(300, function(){
                        $prds.html(response);
                        $prds.find('.prdlist').show(300);
                    });
                }
            });
        });

    });

    function checkFolders(){
        $('.cattreemain li').each(function(){
            $tocheck = $(this).find('ul');

            if($tocheck.is(':visible')){
                $(this).children('i').addClass('fa-folder-open');
            } else {
                $(this).children('i').removeClass('fa-folder-open');
            }
        })
    }
</script>
