<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\cmenu\ContextMenu;
if(!empty($_COOKIE['openedCats'])){
    $cookie = unserialize($_COOKIE['openedCats']);
} else {
    $cookie = array();
}
$cookie = array_unique($cookie);
?>

<ul class="catlist" id="category_<?php if(isset($model[0])){echo $model[0]->parent;}?>" style="<?php if(!isset($static)):?>display: none<?php endif;?>">
    <?php foreach($model as $item):?>
        <li data-sort="<?=$item->sort_order;?>" data-cat="<?=$item->categoryID?>"><?php if($item->hasChilds):?><i class="fa fa-folder"></i><?php endif;?>

        <span style="<?php if($item->inTrash):?>text-decoration:line-through;color:red;<?php endif;?>" class="deleteCatSpan"><?=$item->name_ru?>
            <?php if(!$item->hasChilds):?>
                <?php if(!$item->inTrash):?>
                    <a class="deleteCat" href="<?=Url::toRoute(['/categories/deletecategory', 'id' => $item->categoryID])?>" style="cursor: pointer">[Удалить <span style="margin:0;display: inline;" class="fa fa-times"></span>]</a>
                <?php else:?>
                    <b style="color:#000">в корзине</b>
                <?php endif;?>
            <?php endif;?>
        </span>
            <?php if(!empty($cookie)):?>
                <?php foreach($cookie as $c):?>
                    <?php if($c == $item->categoryID):?>
                        <?php $preload = \common\models\SCCategories::find()->where("parent = $c")->orderBy("sort_order ASC")->all();?>
                        <?php echo $this->render('subtree', ['model'=>$preload, 'static'=>1]);?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
        </li>
    <?php endforeach; ?>
</ul>

<?php if(!empty($child)):?>

    <?php if(!empty($model)):?>
        <hr>
    <?php endif;?>

<ul class="catlist" style="<?php if(!isset($static)):?>display: none<?php endif;?>">
    <?php foreach($child as $item):?>
        <li class="appended" data-cat="<?=$item->categoryID?>"><?php if($item->hasChilds):?><i class="fa fa-folder"></i><?php endif;?>
            <span><?=$item->name_ru?></span> <span class="childpointer">дополнительная подкатегория</span>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif;?>

<?php if(isset($model[0])){
    $js = "$('#category_".$model[0]->parent."').sortable({
        axis: \"y\",
        cursor: \"move\",
        items: \"> li\",
        scroll : false,
        update: function( event, ui ) {
            resort(ui.item);
        }
    })";
$this->registerJs($js);
}



?>


