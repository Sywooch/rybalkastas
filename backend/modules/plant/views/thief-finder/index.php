<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 20.07.2016
 * Time: 10:55
 */

use yii\helpers\ArrayHelper;

$this->title = 'Поиск воришек';
$this->params['breadcrumbs'][] = $this->title;


$form = \yii\widgets\ActiveForm::begin();
?>

    <?=$form->field($model, 'orderStatus')->dropDownList(ArrayHelper::map(\common\models\SCOrderStatus::find()->asArray()->all(), 'statusID', 'status_name_ru'))?>
    <?=$form->field($model, 'shippingMethod')->dropDownList(ArrayHelper::map(\common\models\SCOrders::find()->where("shipping_type <> ''")->asArray()->all(), 'shipping_type', 'shipping_type'))?>
    <?=$form->field($model, 'positions')->textarea()?>

    <input type="submit" class="btn btn-flat btn-block" value="Отправить" />
<?php \yii\widgets\ActiveForm::end();?>
