<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 13.11.2017
 * Time: 11:01
 */

if (!empty($_GET['product'])) {
    $model = \common\models\SCProducts::findOne($_GET['product']);
} elseif (!empty($_POST['AddToCartForm']['product'])) {
    $model = \common\models\SCProducts::findOne($_POST['AddToCartForm']['product']);
} else {
    $model = \common\models\SCProducts::find()->where(['categoryID' => $_GET['id']])->orderBy("IF( in_stock > 0, CONCAT(1), CONCAT(0)) DESC")->addOrderBy('sort_order ASC')->one();
}


?>
<?php if (!empty($model)): ?>
<div class="table-good presence">
    <span>Наличие</span>
    <?php if ($model->canAdd == 1): ?>
        <strong>
            <link itemprop="availability" href="http://schema.org/InStock"/>
            Есть в наличии</strong>
    <?php else: ?>
        <strong class="text-red">
            <link itemprop="availability" href="http://schema.org/InStock"/>
            <?php if(!empty($model->category->na_message)){
                echo $model->category->na_message;
            } else {
                echo 'Нет в наличии';
            }?>

        </strong>
    <?php endif; ?>
</div>
<?php endif; ?>
