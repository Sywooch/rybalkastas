<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 16:44
 */
use yii\widgets\Pjax;


$this->title = $model->name_ru;
$this->render('parts/_breadcrumbs_block', ['model'=>$model]);


?>

<div class="text-center">
    <h1 class="page-header"><?= $model->name_ru ?></h1>
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
    <?= $this->render('parts/_product_chunk', ['model' => $renderProduct, 'prependix'=>'size_chooser']); ?>
    <?php Pjax::end(); ?>

    <?php
    $alloptions = [];
    foreach ($products as $p) {
        foreach ($p->attrs as $a) {
            $alloptions[$a->optionID] = $a->optionName;
        }
    }

    ?>


    <div class="box box-primary">
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Описание</a></li>
                    <?php if (strpos($model->description_ru, '<iframe') !== false) :?>
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Видео</a></li>
                    <?php endif;?>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Отзывы (<?= count($ratings) ?>)</a></li>
                </ul>
                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <?=$this->render('parts/_description', ['model'=>$model])?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <?=$this->render('parts/_video', ['model'=>$model])?>
                    </div>

                    <div class="tab-pane" id="tab_4">
                        <?=$this->render('parts/_comments', ['model'=>$model, 'rating'=>$rating, 'ratings'=>$ratings, 'rpages'=>$rpages]);?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>


    <?=$this->render('parts/_description', ['model'=>$model])?>

    <?=$this->render('_related_products', ['model'=>$model]);?>

    <?=$this->render('_same_products', ['model'=>$model]);?>

</div>

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

