<?php
use dosamigos\multiselect\MultiSelect;
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 20.03.2017
 * Time: 10:16
 */

/**
 * COND:[2500=2500 - 2550|3000=3000 - 3050|3500=3500 - 3550|4000=4000 - 4050|6000=6000 - 6050|8000=8000 - 8050|10000=10000 - 10050|>10000=10000 - 90000]
 * */

$condStr = $option->option->filterStep;
preg_match('/\[(.*?)\]/', $condStr, $matches);
$conditions = $matches[1];
$condAr = explode('|', $conditions);

$condData = [];
foreach ($condAr as $condItem) {
    $condItemSplit = explode('=', $condItem);
    $condData[] = ['name' => $condItemSplit[0], 'value' => $condItemSplit[1]];
}

?>
<?php
$data = [];
foreach ($condData as $cd){
    $data['items'][$cd['value']] = $cd['name'];
}
echo MultiSelect::widget([
    'id'=>"filter_".$option->optionID,
    "options" => ['multiple'=>"multiple"], // for the actual multiselect
    'model' => $searchModel,
    'attribute' => 'filter[option_'.$option->optionID.']', // name for the form
    'data' => $data['items'], // data as array
    'value' => [ 0, 2], // if preselected
    "clientOptions" =>
        [
            //"includeSelectAllOption" => true,
            //'numberDisplayed' => 2
            'nonSelectedText'=> 'Не выбрано!',
            'allSelectedText'=> 'Выбрано',
            'buttonClass' => 'multiselect dropdown-toggle btn btn-default btn-block'
        ],
]);
?>


