<?php
$this->title = "Выгрузка товаров из 1С";

use yii\helpers\Json;
use backend\assets\TreeviewAsset;
use yii\widgets\Pjax;


TreeviewAsset::register($this);
?>

<div class="col-md-12">
    <div id="tree">
        <?php Pjax::begin();?>
        <?=$this->render('_categories', ['model'=>$model, 'categoryID'=>$categoryID])?>
        <?php Pjax::end();?>
    </div>
</div>