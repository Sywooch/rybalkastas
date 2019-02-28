<div style="padding: 0 20px 20px 20px">
    <div style="margin-top: 20px;margin-bottom: 20px">
        <h1 style="text-align: center;font-weight: 100">Заказ №<?=$order->number?> успешно сформирован!</h1>
    </div>
    <div style="text-align: center">
        <div style="background-color: #fff; margin-top: 10px;text-align: left;">
            <b><span style="color:red;">Внимание!!!</span> Это сообщение сформировано автоматически. Не нужно на него отвечать!</b>

            <br>
            <br>

            <i>Наши менеджеры свяжутся с Вами в ближайшее время.</i>

            <br>
            <br>
            <hr>
            <br>
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
                <?php if($order->payment_type):?><span>Способ оплаты: <b><?=$order->payment_type?></b></span><br/><?php endif;?>
                Адрес доставки: <b><?=$order->shipping_state?> <?=$order->shipping_address?></b><br/>
                Получатель: <b><?=$order->customer_firstname.' '.$order->customer_lastname?></b>
            </p>

            <br>
            <hr>
            <br>
        </div>
    </div>
</div>
