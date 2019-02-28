<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.12.2015
 * Time: 13:12
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\components\ArrayMapHelper;

$this->title = 'Связь страницы с учетными записями менеджера';
?>

<div class="col-md-12">
    <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
            <div class="expert_av" style="display:inline-block; vertical-align:middle;width: 65px;   height: 65px; float: left;   background: url(/img/experts/<?=$model->picture?>) no-repeat;border-radius: 150px;background-size: 212px 136px;   -webkit-border-radius: 150px;   -moz-border-radius: 150px;   background-position: top left 50%;"></div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username"><?=$model->expert_name?> <?=$model->expert_last_name?></h3>
            <h5 class="widget-user-desc"><?=$model->shop?></h5>
        </div>
    </div>
</div>

<?php $form = ActiveForm::begin(); ?>
<?php $dataApi = ArrayMapHelper::cmap(\common\models\api\ChatOperators::find()->orderBy('first_name')->all(), 'id', ['first_name','last_name'], ' ')?>
<?=$form->field($connection, 'api_id')->widget(Select2::classname(), [
    'data' => $dataApi,
    'options' => ['placeholder' => 'Найти по имени'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

<?php $dataTta = \yii\helpers\ArrayHelper::map(dektrium\user\models\User::find()->orderBy('email')->all(), 'id', 'email')?>
<?=$form->field($connection, 'tta_id')->widget(Select2::classname(), [
    'data' => $dataTta,
    'options' => ['placeholder' => 'Найти по Email'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

<?php $dataSc = \yii\helpers\ArrayHelper::map(\common\models\SCCustomers::find()->where('Email LIKE "%rybalkashop.ru%" AND Login <> ""')->orderBy('Email')->groupBy('Email')->all(), 'customerID', 'Email')?>
<?=$form->field($connection, 'sc_id')->widget(Select2::classname(), [
    'data' => $dataSc,
    'options' => ['placeholder' => 'Найти по Email'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

<button type="submit" class="btn btn-success btn-block btn-flat">Сохранить</button>

<?php
ActiveForm::end();
?>
