<table class="data_table table">
    <tbody>
    <tr id="threlement">
        <th class="tdelement"><span title="sort this column"><b>Наименование товара</b></span></th>
        <?php foreach($alloptions as $ao):?>
            <th class="tdelement"><?=$ao?></th>
        <?php endforeach;?>
        <th class="tdelement" id="pricehead"><span title="sort this column"><b>Цена</b></span></th>
        <th class="tdxelement"><b>Купить</b></th>
    </tr>
    <?php foreach($products as $product):?>
        <tr>
            <td class="selector_td"><a href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>"><span><b><?=$product->name_ru?></b></span></a></td>
            <?php foreach($alloptions as $k=>$ao):?>
                <td class="selector_td"><a href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>"><?=\common\models\SCProductOptionsValues::find()->where("productID = $product->productID AND optionID = $k")->one()->option_value_ru;?></a></td>
            <?php endforeach;?>
            <td class="isSpecialPrice selector_td">
                <a href="<?=\yii\helpers\Url::to(['category', 'product'=>$product->productID, 'id'=>$id])?>">
                    <?php if($product->list_price > $product->Price):?>
                        <span class="old"><?=$product->oldPrice?>&nbsp;руб.</span>
                    <?php endif;?>
                    <span class="new"><?=$product->normalPrice?>&nbsp;руб.</span>
                </a>
            </td>
            <td>
                <?php if($product->in_stock > 0):?>
                    <span class="tobasket">В&nbsp;корзину</span>
                    <span class="instock">есть в наличии</span>
                <?php else:?>
                    <span class="text-red text-bold">Нет в наличии</span>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>