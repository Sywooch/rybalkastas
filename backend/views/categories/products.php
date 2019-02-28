<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\cmenu\ContextMenu;
use common\models\SCCategories;
$this->title = "Загрузка файлов";
$main = SCCategories::find()->where("categoryID = $categoryID")->one();

?>
<?php $form = \kartik\form\ActiveForm::begin(['action' => 'move-products']);?>
<p>
    <?= Html::a('Изменить категорию '.$main->name_ru, ['update', 'id'=>$main->categoryID], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Открыть '.$main->name_ru.' на сайте', \Yii::$app->urlManagerFrontend->createAbsoluteUrl(['shop/category', 'id'=>$main->categoryID]), ['class' => 'btn btn-warning']) ?>
    <?=$this->render('_select_to_move', ['val'=>$main->categoryID])?>
</p>

<?php if(!empty($products)):?>

<ul style="<?php if(!isset($static)):?>display: none<?php endif;?>" class="prdlist">
    <?php foreach($products as $item):?>


        <li style="<?php if($item->isCanon):?>background: rgba(255, 0, 0, 0.16);<?php endif;?>" class="toplevel"  data-cat="<?=$item->productID?>">
            <input type="checkbox" class="checkToMove" style="margin-right: 20px" name="Move[<?=$item->productID?>]" value="1"/>
            <span><a style="<?php if($item->inTrash):?> text-decoration: line-through; color:red;<?php endif;?>" href="<?=Url::toRoute(['/categories/editproduct', 'id' => $item->productID])?>"><?=$item->name_ru?></a><?php if($item->isCanon):?> (Канонический) <?php endif;?></span>
            <?php if(Yii::$app->user->can('headField')):?>
                <?php if(!$item->inTrash):?><span class=""><a href="<?=Url::toRoute(['/categories/deleteproduct', 'id' => $item->productID])?>">[Удалить <i style="margin:0" class="fa fa-times"></i>]</a></span><?php else:?><b>в корзине</b><?php endif;?>

            <?php endif;?>
        </li>
    <?php endforeach; ?>


</ul>


<?php else: ?>
<div style="text-align: center" class="prdlist">Категория пуста</div>
<?php endif;?>
<?php \kartik\form\ActiveForm::end();?>
<?php

$js = "$('.prdlist').sortable({
        axis: \"y\",
        cursor: \"move\",
        items: \"> li\",
        scroll : false,
        update: function( event, ui ) {
            resortPrds(ui.item);
        }
    })";
$this->registerJs($js);


?>