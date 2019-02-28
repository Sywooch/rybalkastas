<?php
$products = \common\models\SCProducts::findAll(['categoryID'=>$model->categoryID]);

$prev_array = [];
foreach($products as $prd){
    $prev_array[$prd->optionValue(46)] = $prd;
}

uksort($prev_array, 'cmp');
?>

<ul class="size_grid">
    <?php foreach($prev_array as $k=>$prd):?>
    <li><a href="<?=\yii\helpers\Url::to(['category', 'product'=>$prd->productID, 'id'=>$model->categoryID])?>" class="p_pjax btn btn-circle <?=($prd->productID == $model->productID?"btn-primary":"btn-default")?> <?php if($prd->in_stock <= 0):?>circle-btn-opacity<?php endif;?>"><?=$k?></span></a></li>
    <?php endforeach;?>
</ul>


<?php


function cmp($a, $b)
{

    $sizes = array(
        "XXS" => 0,
        "XS" => 1,
        "S" => 2,
        "М" => 3,
        "M" => 3,
        "L" => 4,
        "XL" => 5,
        "XXL" => 6,
        "XXXL" => 7,
        "3L" => 8,
        "3XL" => 9,
        "4XL" => 10,
        "4L" => 11,
        "5L" => 12,
        "6L" => 13,
        "7L" => 14,
        "LL" => 15,
    );

    $asize = $sizes[$a];
    $bsize = $sizes[$b];

    if ($asize == $bsize) {
        return 0;
    }

    return ($asize > $bsize) ? 1 : -1;
}

