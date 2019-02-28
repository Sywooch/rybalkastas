<?php

/* @var \common\models\SCOrders $order */
/* @var \common\models\SCExperts $expert */

?>

<div style="padding: 0 20px 20px 20px">
    <div style="margin-top: 20px;margin-bottom: 20px">
        <h1 style="text-align: center;font-weight: 100">Заказ №<?=$order->number?> <?=$order->mailTitle?></h1>
        <?php if($order->payed == 1):?>
            <h3 style="text-align: left;color:#228B22">Заказ оплачен</h3>
        <?php endif?>
    </div>

    <div style="text-align: center">
        <div style="background-color: #fff; margin-top: 10px;text-align: left;">
            <?php if(!empty($order->expert)):?>
                <i>Торговая точка ответственная за Ваш заказ: <a href="http://rybalkashop.ru/page/<?=$order->expert->shopObj->slug?>" target="_blank"><b><?=$order->expert->shopObj->name?></b></a></i>

                <br>
                <br>

                <?php if (!empty($order->expertsPair)): ?>
                    <i>Ваши менеджеры:</i>
                    <ul>
                        <?php foreach ($order->expertsPair as $expert): ?>
                            <li>
                                <b><?= $expert->expert_fullname ?></b>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <br>

                    <i>Адрес электронной почты:</i>
                    <?php $mailTo = $order->expertsPairMail ? $order->expertsPairMail : 'contacts@rybalkashop.ru' ?>
                    <ul>
                        <li>
                            <a href="mailto:<?= $mailTo ?>"><?= $mailTo ?></a>
                            <?php if ($order->expertsPairMail): ?>
                                <br><i>Для связи с менеджерами по почте - ответьте на это письмо</i>
                            <?php endif; ?>
                        </li>
                    </ul>

                    <br>
                <?php else: ?>
                    <i>Ваш менеджер - <b><?= $order->expert->expert_fullname ?></b> (<a href="mailto:<?= $order->expert->email ?>"><?= $order->expert->email ?></a>)</i>

                    <br>
                <?php endif; ?>
                <i>
                    Телефоны магазина:
                    <ul>
                        <?php foreach(\yii\helpers\Json::decode($order->expert->shopObj->phone) as $phone):?>
                            <li><a href="tel:<?=$phone?>"><?=$phone?></a></li>
                        <?php endforeach;?>
                    </ul>
                </i>
            <?php else:?>
                <p><?= $order->manager_id ?></p>
            <?php endif;?>

            <br>

            <h3 style="font-size: 20px">Состав заказа:</h3>

            <table cellpadding="5" style="width:100%;border-collapse: collapse;">
                <tr>
                    <th style="background-color:#c2181d; color:#fff;">Наименование</th>
                    <th style="background-color:#c2181d; color:#fff;">Количество</th>
                    <th style="background-color:#c2181d; color:#fff;">Сумма</th>
                </tr>
                <?php $items = \common\models\SCOrderedCarts::find()->where("orderID = $order->orderID")->all();?>
                <?php foreach($items as $item):?>
                    <tr>
                        <td style="border: 1px solid #D2D2D2"><?=$item->name;?></td>
                        <td style="border: solid 1px #D2D2D2; text-align: center;"><?=$item->Quantity;?></td>
                        <td style="border: solid 1px #D2D2D2; text-align: center;"><?=number_format($item->Price,2);?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="4" style="border:solid 1px #D2D2D2;text-align:right;font-weight:bold;">Итого: <b><?=$order->order_amount?> руб.</b></td>
                </tr>
            </table>

            <br>
            <hr>
            <br>

            <h3 style="font-size: 20px">Информация:</h3>
            <p>
                Способ доставки: <b><?=$order->shipping_type?></b><br/>
                Способ оплаты: <b><?=$order->payment_type?></b><br/>
                Адрес доставки: <b><?=$order->shipping_state?> <?=$order->shipping_address?></b><br/>
                Получатель: <b><?=$order->customer_firstname.' '.$order->customer_lastname?></b>
            </p>

            <br>
            <hr>
            <br>

            <p style="text-align: center">
                Претензии по обработке заказа просьба присылать на адрес:
                <br>
                <a href="mailto:contacts@rybalkashop.ru">contacts@rybalkashop.ru</a>
                <br>
            </p>
        </div>
    </div>
</div>
