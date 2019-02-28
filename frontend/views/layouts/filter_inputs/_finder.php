<?php

use yii\helpers\ArrayHelper;
use common\models\SCProductOptionsValues;

/**
 * COND:[2500=2500 - 2550|3000=3000 - 3050|3500=3500 - 3550|4000=4000 - 4050|6000=6000 - 6050|8000=8000 - 8050|10000=10000 - 10050|>10000=10000 - 90000]
 */

$prdAr = ArrayHelper::getColumn($model->products, 'productID');

$optQuery = SCProductOptionsValues::find()
       ->where(['in', 'productID', $prdAr])
    ->andWhere(['optionID'=>$option->option->optionID])
    ->andWhere("option_value_ru <> ''")
     ->groupBy('option_value_ru');

$optQuery = $optQuery->all();

$vals = [];

foreach ($optQuery as $o) {
    if (strpos($o->option_value_ru, '-') !== false) {
        $ex = explode('-', $o->option_value_ru);

        $range = 1;

        if (strpos($ex[0], '.') !== false || strpos($ex[1], '.') !== false) $range = 0.5;

        foreach (range(round($ex[0]), round($ex[1])) as $e){
            $vals[] = $e;
        }
    } else {
        $vals[] = $o->option_value_ru;
    }
}

$vals = array_unique($vals);
asort($vals);

$condData = [];

foreach ($vals as $val) {
    $condData[] = ['name' => $val, 'value' => $val];
}

$data = [];

foreach ($condData as $cd){
    //if (!is_numeric($cd['value'])) continue;
    $data['items'][$cd['value']] = $cd['name'];
}

if(!empty($data['items'])):
    echo\yii\helpers\Html::activeCheckboxList($searchModel, 'filter[option_'.$option->optionID.']', $data['items'], ['class'=>'filter_columns']);
endif;
