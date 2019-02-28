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
 * @var \common\models\SCOrders $model
 */

$this->title = Yii::t('user', 'Заказ №' . $model->number);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <div>
                    <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/user/settings/orders']) ?>"><i class="fa fa-chevron-left"></i> Назад</a>
                    <?php if($model->statusID == 5):?>
                        <a class="btn btn-success pull-right" href="<?= \yii\helpers\Url::to(['/user/settings/confirm-order', 'id'=>$model->orderID]) ?>">Подтвердить получение <i class="fa fa-check"></i> </a>
                    <?php endif;?>
                </div>

                <div class="col-md-6">
                    <h3>Доставка - <?= $model->shipping_type ?></h3>
                    <p><?= $model->shipping_firstname . ' ' . $model->shipping_lastname; ?></p>
                    <p><?= $model->shipping_address; ?></p>
                    <p><?= $model->shipping_state; ?>, <?= $model->shipping_country; ?></p>
                </div>
                <div class="col-md-6">
                    <h3>Оплата - <?= $model->payment_type ?></h3>
                    <p><?= $model->billing_firstname . ' ' . $model->billing_lastname; ?></p>
                    <p><?= $model->billing_address; ?></p>
                    <p><?= $model->billing_state; ?>, <?= $model->billing_country; ?></p>
                    <p>
                        <?php
                        $payment = \common\models\SCPaymentTypes::find()->where(['Name_ru' => $model->payment_type])->one();
                        if (!empty($payment) && in_array($payment->PID, [14, 13])):
                        ?>
                        <?php if ($model->payed == 1): ?>
                            <b class="text-success">Заказ оплачен</b>
                        <?php else: ?>
                            <b class="text-danger">Заказ не оплачен</b>
                        <?php endif ?>
                    <?php endif; ?>
                    </p>
                </div>

            </div>
            <div class="col-md-12">
                <h3>Состав заказа</h3>
                <div>
                    <?php $items = \common\models\SCOrderedCarts::find()->where("orderID = $model->orderID")->all(); ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>
                            <th>Количество</th>
                            <th>Стоимость</th>
                        </tr>
                        <?php $i = 1;
                        foreach ($items as $item): ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>
                                    <a href="<?= \yii\helpers\Url::to(['/shop/category', 'id' => $item->product->categoryID, 'product' => $item->product->productID]) ?>"><?= $item->name; ?></a>
                                </td>
                                <td><?= $item->Quantity; ?></td>
                                <td><?= number_format($item->Price, 2); ?></td>
                            </tr>
                            <?php $i++;endforeach; ?>
                    </table>
                </div>
                <div class="col-md-3 col-md-offset-8">
                    Итого: <b><?= $model->order_amount ?> руб.</b>
                </div>
            </div>
            <div class="col-md-12">
                <div class="collapse" id="collapseExample2">
                    <?php
                    $versions = $model->versionList;
                    foreach ($versions as $k => $v):
                        ?>
                        <div>v<?= $v['id']; ?></div>
                        <div class="">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Наименование</th>
                                    <th>Количество</th>
                                    <th>Стоимость</th>
                                </tr>
                                <?php $i = 1;
                                foreach ($v['data'] as $item):?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $item->name; ?></td>
                                        <td><?= $item->Quantity; ?></td>
                                        <td><?= number_format($item->Price, 2); ?></td>
                                    </tr>
                                    <?php $i++;endforeach; ?>
                            </table>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <script>
                $("[data-toggle=popover]")
                    .popover({html: true});
            </script>
        </div>
    </div>
</div>
