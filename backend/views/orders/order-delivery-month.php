<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 22.01.2018
 * Time: 11:27
 */

$ar = [];
$arDates = [];
foreach ($array as $a){
    $slug = \yii\helpers\Inflector::slug(trim($a));
    $ar[$slug] = ['name' => $a];
}
foreach ($model as $m){
    if($m['shipping_type'] == 'Самовывоз из магазина' || $m['shipping_type'] == 'Пункты Самовывоза' || $m['shipping_type'] == 'Пункты самовывоза' || $m['shipping_type'] == 'Самовывоз - Дзержинский' ) continue;
    $yearMonth = Yii::$app->formatter->asDate($m['order_time'], 'yyyy-MM-dd');
    $slug = \yii\helpers\Inflector::slug(trim($m['shipping_type']));
    if(empty($arDates[$yearMonth][$slug])){
        $arDates[$yearMonth][$slug] = 1;
    } else {
        $arDates[$yearMonth][$slug] += 1;
    }
}
?>
<table class="table table-hover table-striped table-bordered">
    <tr>
        <th style="border: 1px solid #aaaaaa;">Дата</th>
        <?php foreach($ar as $a):?>
        <th style="border: 1px solid #aaaaaa;"><?=$a['name']?></th>
        <?php endforeach;?>
        <th style="border: 1px solid #aaaaaa;">ИТОГО</th>
    </tr>
    <?php foreach ($arDates as $k=>$arD):?>
    <tr>
        <td style="border: 1px solid #aaaaaa;">
            <a href="<?= \yii\helpers\Url::to(['order-delivery-month', 'month'=>$k])?>" target="_blank"> <?=$k?></a>
        </td>
        <?php $end = 0; ?>
        <?php foreach($ar as $slug=>$a):?>
            <td style="border: 1px solid #aaaaaa;"><?=!empty($arD[$slug])?$arD[$slug]:0?></td>
            <?php $end += !empty($arD[$slug])?$arD[$slug]:0; ?>
        <?php endforeach;?>
        <td style="border: 1px solid #aaaaaa;"><b><?=$end?></b></td>
    </tr>
    <?php endforeach;?>

</table>