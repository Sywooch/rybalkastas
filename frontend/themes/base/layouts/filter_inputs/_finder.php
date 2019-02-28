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
$prdAr = \yii\helpers\ArrayHelper::getColumn($model->products, 'productID');
$optQuery =  \common\models\SCProductOptionsValues::find()
    ->where(['in', 'productID', $prdAr])
    ->andWhere(['optionID'=>$option->option->optionID])
    ->andWhere("option_value_ru <> ''")
    ->groupBy('option_value_ru')
    ->all();


$vals = [];
foreach ($optQuery as $o){
    if(strpos($o->option_value_ru, '-') !== false){
        $ex = explode('-', $o->option_value_ru);
        $range = 1;
        if(strpos($ex[0], '.') !== false || strpos($ex[1], '.') !== false) $range = 0.5;
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

?>
<?php
$data = [];
foreach ($condData as $cd){
    $data['items'][$cd['value']] = $cd['name'];
}

?>

<?php if(!empty($data['items'])):?>
<?=\yii\helpers\Html::activeCheckboxList($searchModel, 'filter[option_'.$option->optionID.']', $data['items'], ['class'=>'filter_columns'])?>
<?php endif;?>

