<?php if(!$ajax):?>
    <?php $this->title = "Заказ №".sprintf("%08d", $model->orderID);?>
<?php endif;?>

<?php if($print):?>
    <h1><?=$this->title?> </h1>
<?php endif;?>
(<?=\common\models\SCOrderStatus::find()->where("statusID = $model->statusID")->one()->status_name_ru?>)
<div class="col-md-12">
    <div class="pull-right">
        <?php if($ajax):?>
        <a href="<?=\yii\helpers\Url::to(['/orders/view', 'id'=>$model->orderID]);?>" data-toggle="tooltip" data-original-title="Открыть в новой вкладке" target="_blank"><i class="fa fa-eye"></i></a>
        <?php endif;?>
        <a href="<?=\yii\helpers\Url::to(['/orders/view', 'id'=>$model->orderID, 'print'=>1]);?>" data-toggle="tooltip" data-original-title="Печать" target="_blank"><i class="fa fa-print"></i></a>

    </div>
    <h3>Информация о пользователе</h3>
    <div>
        <?php $customer = \common\models\SCCustomers::find()->where("customerID = $model->customerID")->one();?>
        <?php if(!empty($customer->Login)):?>
            <p><?=$model->customer_firstname.' '.$model->customer_lastname;?> (логин: <?=$customer->Login?>)</p>
        <?php else:?>
            <p><?=$model->customer_firstname.' '.$model->customer_lastname;?></p>
        <?php endif;?>
        <p><a href="mailto:<?=$model->customer_email;?>"><?=$model->customer_email;?></a></p>
        <p><?=$model->user_phone;?></p>
    </div>
</div>
<div class="col-md-6">
    <h3>Доставка - <?=$model->shipping_type ?></h3>
    <p><?=$model->shipping_firstname.' '.$model->shipping_lastname;?></p>
    <p><?=$model->shipping_address;?><?php if(!empty($model->shipping_zip))echo ', Индекс: '.$model->shipping_zip?></p>
    <p><?=$model->shipping_state;?>, <?=$model->shipping_country;?></p>
</div>
<div class="col-md-6">
    <h3>Оплата - <?=$model->payment_type ?></h3>
    <p><?=$model->billing_firstname.' '.$model->billing_lastname;?></p>
    <p><?=$model->billing_address;?></p>
    <p><?=$model->billing_state;?>, <?=$model->billing_country;?></p>
</div>

<?php if(!empty($model->customers_comment)):?>
    <div class="col-md-12">
        <p class="bg-warning"><?=$model->customers_comment?></p>
    </div>
<?php endif;?>

<?php if(!empty($customer->Login)):?>
<hr>
<div class="col-md-12">
    <?php if(!$print):?>
    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Информация о пользователе
    </a>

    <div class="collapse" id="collapseExample">
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
                                <?=$customer->Login?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Имя
                            </td>
                            <td>
                                <?=$customer->first_name?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Фамилия
                            </td>
                            <td>
                                <?=$customer->last_name?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email
                            </td>
                            <td>
                                <?=$customer->Email?>
                            </td>
                        </tr>
                        <?php foreach($customer->regfields as $f):?>
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
                    <?php foreach($customer->orders as $o):?>
                        <tr>
                            <td><a <?php if($ajax):?>target="_blank"<?php endif;?> href="<?=\yii\helpers\Url::toRoute(['orders/view', 'id'=>$o->orderID]);?>"><?=$o->number?></a></td>
                            <td><?=Yii::$app->formatter->asDatetime(strtotime($o->order_time));?></td>
                            <td><?=$o->payment_type?></td>
                            <td><?=$o->shipping_type?></td>
                            <td><?=$o->order_amount?></td>
                            <td><?=$o->status?></td>
                        </tr>
                    <?php endforeach;?>
                    </table>
                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 col-md-offset-9">
                        <h4>Итого:</h4>
                        <?php foreach($customer->orderSummary as $s):?>
                            <p style="color: #<?=$s['color']?>;"><?=$s['status'];?>: <b><?=$s['amount'];?></b></p>
                        <?php endforeach;?>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
    <?php else:?>

    <h3>Контактная информация</h3>
        <table class="table table-bordered table-striped">
            <tr>
                <td>
                    Логин
                </td>
                <td>
                    <?=$customer->Login?>
                </td>
            </tr>
            <tr>
                <td>
                    Имя
                </td>
                <td>
                    <?=$customer->first_name?>
                </td>
            </tr>
            <tr>
                <td>
                    Фамилия
                </td>
                <td>
                    <?=$customer->last_name?>
                </td>
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    <?=$customer->Email?>
                </td>
            </tr>
            <?php foreach($customer->regfields as $f):?>
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
        <h3>История заказов</h3>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Номер заказа</th>
                <th>Время заказа</th>
                <th>Оплата</th>
                <th>Доставка</th>
                <th>Стоимость</th>
                <th>Статус</th>
            </tr>
            <?php foreach($customer->orders as $o):?>
                <tr>
                    <td><?=$o->number?></td>
                    <td><?=Yii::$app->formatter->asDatetime(strtotime($o->order_time));?></td>
                    <td><?=$o->payment_type?></td>
                    <td><?=$o->shipping_type?></td>
                    <td><?=$o->order_amount?></td>
                    <td><?=$o->status?></td>
                </tr>
            <?php endforeach;?>
        </table>
        <div class="clearfix"></div>
    <?php endif;?>
</div>
<?php endif;?>
<div class="col-md-12">
    <h3>Состав заказа</h3>
    <div>
        <?php $items = \common\models\SCOrderedCarts::find()->where("orderID = $model->orderID")->all();?>
        <table class="table table-bordered table-striped">
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Стоимость</th>
            </tr>
        <?php $i=1;foreach($items as $item):?>
            <tr>
                <td><?=$i;?></td>
                <td><a style="white-space: normal!important;text-align: left;" href="#" role="button" class="btn popovers" data-toggle="popover" title="" data-content='<a href="http://rybalkashop.ru/index.php?categoryID=<?=$item->product->categoryID?>&product=<?=$item->product->productID?>" target="_blank">Ссылка на сайт</a> <br/> <a href="http://rybalkashop.ru/ttadmin/web/index.php?r=categories%2Feditproduct&id=<?=$item->product->productID?>" target="_blank">Ссылка на админку</a>'><?=$item->name;?></a></td>
                <td><?=$item->Quantity;?></td>
                <td><?=number_format($item->Price,2);?></td>
            </tr>
        <?php $i++;endforeach;?>
        </table>
    </div>
    <div class="col-md-3 col-md-offset-8">
        Итого: <b><?=$model->order_amount?> руб.</b>
    </div>
</div>
<div class="col-md-12">
    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
        История изменений
    </a>
    <div class="collapse" id="collapseExample2">
        <?php
        $versions = $model->versionList;
        foreach ($versions as $k=>$v):
        ?>
        <div>v<?=$v['id'];?></div>
            <div class="">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Количество</th>
                        <th>Стоимость</th>
                    </tr>
                    <?php $i=1;foreach($v['data'] as $item):?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?=$item->name;?></td>
                            <td><?=$item->Quantity;?></td>
                            <td><?=number_format($item->Price,2);?></td>
                        </tr>
                        <?php $i++;endforeach;?>
                </table>
            </div>
        <?php endforeach;?>
    </div>
</div>
<div class="clearfix"></div>
<?php if($print):?>
<script>
    window.print();
</script>
<?php endif;?>
<script>
    $("[data-toggle=popover]")
        .popover({html:true});
</script>

