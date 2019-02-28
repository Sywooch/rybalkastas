<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Номер заказа</th>
                        <th>Время заказа</th>

                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                    <?php foreach($orders as $o):?>
                        <tr>
                            <td><a href="<?=\yii\helpers\Url::toRoute(['/user/settings/order', 'id'=>$o->orderID]);?>"><?=$o->number?></a></td>
                            <td><?=$o->date?></td>

                            <td><?=$o->order_amount?></td>
                            <td style="color:#<?=$o->statusModel->color?>"><?=$o->statusTitle?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</div>
