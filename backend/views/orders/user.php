<?php $this->title = $model->first_name.' '.$model->last_name?>

<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Контактная информация</a></li>
        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">История заказов</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>
                        Логин
                    </td>
                    <td>
                        <?=$model->Login?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Имя
                    </td>
                    <td>
                        <?=$model->first_name?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Фамилия
                    </td>
                    <td>
                        <?=$model->last_name?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Email
                    </td>
                    <td>
                        <?=$model->Email?>
                    </td>
                </tr>
                <?php foreach($model->regfields as $f):?>
                    <tr>
                        <td>
                            <?=$f['name'];?>
                        </td>
                        <td>
                            <?=$f['value'];?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
            <div class="clearfix"></div>

        </div>
        <div role="tabpanel" class="tab-pane" id="messages">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Номер заказа</th>
                    <th>Время заказа</th>
                    <th>Оплата</th>
                    <th>Доставка</th>
                    <th>Стоимость</th>
                    <th>Статус</th>
                </tr>
                <?php foreach($model->orders as $o):?>
                    <tr>
                        <td><a target="_blank" href="<?=\yii\helpers\Url::toRoute(['orders/view', 'id'=>$o->orderID]);?>"><?=$o->number?></a></td>
                        <td><?=Yii::$app->formatter->asDatetime(strtotime($o->order_time));?></td>
                        <td><?=$o->payment_type?></td>
                        <td><?=$o->shipping_type?></td>
                        <td><?=$o->order_amount?></td>
                        <td><?=$o->status?></td>
                    </tr>
                <?php endforeach;?>
            </table>
            <div class="clearfix"></div>
            <div class="col-md-3 col-md-offset-9">
                <h4>Итого:</h4>
                <?php foreach($model->orderSummary as $s):?>
                    <p style="color: #<?=$s['color']?>;"><?=$s['status'];?>: <b><?=$s['amount'];?></b></p>
                <?php endforeach;?>
            </div>
            <div class="clearfix"></div>
            <hr>
        </div>
        <div class="clearfix"></div>
    </div>

</div>