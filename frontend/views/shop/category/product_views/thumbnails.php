<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 16:44
 */
use yii\widgets\Pjax;
use frontend\assets\ThumbProductAsset;

$enableReviews = boolval(Yii::$app->settings->get('reviews', 'products'));
//$this->title = $model->name_ru;
$this->render('parts/_breadcrumbs_block', ['model'=>$model]);



?>

<?php
$path = $model->path;
$path_ids = \yii\helpers\ArrayHelper::getColumn($path, 'id');
if(!!array_intersect([742, 6198, 105012, 362, 5189, 2517, 2519, 2520, 371, 121086, 2518], $path_ids) && $model->meta->maxPrice >= 10000){
    echo '<img class="category_head_picture img-thumbnail" src="/img/slider/56b8502ace19c.jpg" alt="Тубус в подарок">';
}
if(!!array_intersect([124055], $path_ids)){
    echo '<img class="category_head_picture img-thumbnail" src="/img/content/KssVAMSRg-mpRkR5kByj1NVlNN.jpg" alt="Тубус в подарок">';
}
?>

<div class="fancy-title title-dotted-border title-center">
    <h1><?= $model->name_ru ?></h1>
</div>
<?php if (!empty($model->head_picture)): ?>
    <img class="category_head_picture img-thumbnail"
         src="<?=Yii::$app->imageman->load('/products_pictures/'.$model->head_picture, '955x165', Yii::$app->settings->get('image', 'headPicture'), false, 'head_pics')?>" alt="<?= $model->name_ru; ?>">
<?php endif; ?>

    <div class="card-good">
        <?php Pjax::begin(['id' => 'productContainer']); ?>
        <?php
        $renderProduct = $products[0];
        if(!empty($product)){
            $renderProduct = \common\models\SCProducts::findOne($product);
        }
        ?>
        <?= $this->render('parts/_product_chunk', ['model' => $renderProduct/*, 'appendix'=>'color_grid'*/]); ?>
        <?php Pjax::end(); ?>


        <?=$this->render('parts/_brandlink', ['model'=>$model])?>


        <div class="box box-primary">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Другие цвета</a></li>
                        <?php if (strpos($model->description_ru, '<iframe') !== false) :?>
                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Видео</a></li>
                        <?php endif;?>
                        <?php if($enableReviews):?>
                        <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Отзывы (<?= count($ratings) ?>)</a></li>
                        <?php endif;?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="modification-table">
                                <?= $this->render('parts/_thumbnail_links_a', ['products' => $products, 'id' => $id, '']); ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <?=$this->render('parts/_video', ['model'=>$model])?>
                        </div>

                        <?php if($enableReviews):?>
                        <div class="tab-pane" id="tab_4">
                            <?=$this->render('parts/_comments', ['model'=>$model, 'rating'=>$rating, 'ratings'=>$ratings, 'rpages'=>$rpages]);?>
                        </div>
                        <?php endif;?>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>



        <?=$this->render('parts/_description', ['model'=>$model])?>

        <?=$this->render('parts/_related_products', ['model'=>$model]);?>

        <?=$this->render('parts/_same_products', ['model'=>$model]);?>

        <?php
$js = <<<JS
$('a.p_pjax').click(function(event) {
        event.preventDefault();
        $.pjax.reload({
            container: '#productContainer',
            type       : 'GET',
            url        : $(this).attr("href"),
            data       : {},
            push       : true,
            replace    : false,
            timeout    : 1000,
            showLoader : true,
        });
        $('html, body').animate({
            scrollTop: $("#productContainer").offset().top
        }, 1000);
    });
JS;

$this->registerJs($js);

?>

<div id="product_modal_container"></div>
