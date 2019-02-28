<?php
$categoryID = $model->categoryID;
$products = \common\models\SCProducts::find()->where(['categoryID'=>$categoryID])->all();
?>
<div class="color_pics_addon">
<?php foreach($products as $product):?><a href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$categoryID])?>" class="p_pjax color_pic">
        <img src="<?=\frontend\helpers\ImageHelper::loadImageAbs($product->color_pic)?>"/>
    </a><?php endforeach; ?>
</div>