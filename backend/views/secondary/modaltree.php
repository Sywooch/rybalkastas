<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
?>

<ul class="catlist" style="<?php if(!isset($static)):?>display: none<?php endif;?>">
    <?php foreach($rootCats as $item):?>
        <li data-type="<?=$type?>" data-name="<?=$item->name_ru?>" data-cat="<?=$item->categoryID?>"><?php if($item->hasChilds):?>
            <i class="fa fa-folder"></i><?php endif;?>
            <span><?=$item->name_ru?></span>
            <button type="button" class="pull-right btn btn-xs btn-success selectCatBtn" data-toggle="modal">Выбрать</button>
        </li>
    <?php endforeach; ?>
</ul>

