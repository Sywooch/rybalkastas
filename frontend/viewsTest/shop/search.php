<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 09.03.2017
 * Time: 12:01
 */

/* @var $model common\models\SCCategories */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $products array */
use kartik\widgets\SwitchInput;
use yii\helpers\Html;

$this->title = "Поиск";
$this->params['breadcrumbs'][] = "Поиск";

?>

<div class="category">
    <div class="text-center">
        <div class="fancy-title title-dotted-border title-center">
            <h1>Поиск</h1>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="catalog-block">
        <div class="item-holder">
            <div class="">

                <?php
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => 'category/_category_grid',
                    'itemOptions' => ['class' => 'item col-md-3 col-xs-6'],
                    'id' => 'my-listview-id',
                    'layout' => "<div class=\"items row-eq-height\">{items}</div>\n<div class='clearfix'> </div>{pager}",
                ]);

                ?>
            </div>
            <?php /*
            <div class="text-center">
                <form id="infiniteChanger" action="<?= \yii\helpers\Url::current(); ?>" method="post">
                    <?= \yii\helpers\Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []); ?>
                    <?php if (\Yii::$app->session->get('user.enableInfiniteScroll') == 1): ?>
                        <input type="hidden" name="enableInfinite" value="0"/>
                        <button type="submit" class="btn btn-primary btn">Ограничить количество товаров на странице</button>
                    <?php else: ?>
                        <input type="hidden" name="enableInfinite" value="1"/>
                        <button type="submit" class="btn btn-success btn">Показывать все товары</button>
                    <?php endif; ?>
                </form>
            </div> */?>
        </div>
    </div>
</div>


<?php
$js = <<<JS
    $('#infiniteChanger').on('change','#toggleInfinite',function(){
        $('#infiniteChanger').submit();
    });
JS;

$this->registerJs($js);
?>
