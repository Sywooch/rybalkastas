<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
?>

<ul class="catlist" style="<?php if(!isset($static)):?>display: none<?php endif;?>">
    <?php foreach($rootCats as $item):?>
        <?php
            $isConnected = false;
            if($type == 'parents'){
                $isConnected = $item->parentExists($main);
            } elseif ($type == 'childs') {
                $isConnected = $item->childExists($main);
            } elseif ($type == 'related') {
                $isConnected = $item->relatedExists($main);
            } else /*same*/ {
                $isConnected = $item->sameExists($main);
            }
        ?>

        <li data-cat="<?=$item->categoryID?>"><?php if($item->hasChilds):?>
            <i class="fa fa-folder"></i><?php endif;?>
            <span><?=$item->name_ru?></span>
            <a href="#" class="btn btn-xs btn-success category_chooser" data-name="<?=$item->name_ru?>" data-cat="<?=$item->categoryID?>">Выбрать</a>
        </li>
    <?php endforeach; ?>
</ul>