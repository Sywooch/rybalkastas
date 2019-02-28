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
$this->title = $model->name_ru;
$this->render('parts/_breadcrumbs_block', ['model'=>$model]);
$child_cats = \common\models\SCCategories::find()->select(['categoryID', 'name_ru'])->where(['parent'=>$model->categoryID])->orderBy('sort_order ASC')->asArray()->all();
$renderProduct = \common\models\SCProducts::find()->where(['in', 'categoryID', \yii\helpers\ArrayHelper::getColumn($child_cats, 'categoryID')])->one();


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

        <?= $this->render('parts/_product_chunk', ['model' => $renderProduct/*, 'appendix'=>'color_grid'*/]); ?>
        <?php Pjax::end(); ?>




        <div class="box box-primary">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php
                        $i=0;
                        foreach($child_cats as $cc):
                            $nameEx = explode($model->name_ru, $cc['name_ru']);
                            $name = $nameEx[1];
                            ?>
                            <li class="<?=$i==0?"active":""?>"><a href="#tab_sub_<?=$cc['categoryID']?>" data-toggle="tab" aria-expanded="true">Цвета <?=$name?></a></li>
                        <?php
                        $i++;
                        endforeach;
                        ?>
                        <?php if (strpos($model->description_ru, '<iframe') !== false) :?>
                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Видео</a></li>
                        <?php endif;?>
                        <?php if($enableReviews):?>
                        <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Отзывы</a></li>
                        <?php endif;?>
                    </ul>
                    <div class="tab-content">
                        <?php $i=0;foreach($child_cats as $cc):?>
                            <?php $products = \common\models\SCProducts::find()->where(['categoryID' => $cc['categoryID']])->orderBy("IF( in_stock > 0, CONCAT(1), CONCAT(0)) DESC")->addOrderBy('sort_order ASC')->all();?>
                        <div class="tab-pane <?=$i==0?"active":""?>" id="tab_sub_<?=$cc['categoryID']?>">
                            <div class="modification-table">
                                <?= $this->render('parts/_thumbnail_links_a', ['products' => $products, 'id' => $id, '']); ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <?php $i++;endforeach;?>
                        <!-- /.tab-pane -->
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <?=$this->render('parts/_video', ['model'=>$model])?>
                        </div>

                        <?php if($enableReviews):?>
                        <div class="tab-pane" id="tab_4">
                            <?=$this->render('parts/_comments', ['model'=>$model]);?>
                        </div>
                        <?php endif;?>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>





        <?=$this->render('parts/_related_products', ['model'=>$model]);?>

        <?=$this->render('parts/_same_products', ['model'=>$model]);?>

        <?=$this->render('parts/_comments', ['model'=>$model, 'rating'=>$rating, 'ratings'=>$ratings, 'rpages'=>$rpages]);?>



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
