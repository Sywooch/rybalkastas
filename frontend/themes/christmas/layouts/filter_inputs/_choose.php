<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 20.03.2017
 * Time: 10:16
 */

/**
 * COND:[Все=yes,no|С байтранером=yes|Без байтранера=no]
 * */

$condStr = $option->option->filterStep;
preg_match('/\[(.*?)\]/',$condStr, $matches);
$conditions = $matches[1];
$condAr = explode('|', $conditions);

$condData = [];
foreach ($condAr as $condItem){
    $condItemSplit = explode('=', $condItem);
    $condData[] = ['name'=>$condItemSplit[0], 'value'=>$condItemSplit[1]];
}

?>

<?php
$data = [];
foreach ($condData as $cd){
    $data['items'][$cd['value']] = $cd['name'];
}
?>

<?=\yii\helpers\Html::activeCheckboxList($searchModel, 'filter[option_'.$option->optionID.']', $data['items'])?>

