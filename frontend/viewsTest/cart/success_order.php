<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 25.04.2017
 * Time: 14:29
 */
$this->title = "Успешное оформление заказа";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page">
    <h1 class="page-header text-center">
        Заказ успешно оформлен
    </h1>
    <div class="text-left">
        <h5>Спасибо, что выбрали интернет-магазин Rybalkashop.ru!</h5>
        <br/>
        <p>Номер вашего заказа: <b>#<?=$order->number?></b></p>
        <br/>
        <p>Покупатель: <b><?=$order->customer_lastname?> <?=$order->customer_firstname?></b></p>
        <p>Адрес: <b><?=$order->shipping_address?></b></p>
        <p>Город: <b><?=$order->shipping_state?></b></p>
        <p>Номер телефона: <b><?=$order->user_phone?></b></p>
        <br>
        <p>Способ доставки: <b><?=$order->shipping_type?></b></p>
        <p>Способ оплаты: <b><?=$order->payment_type?></b></p>
        <p>Сумма к оплате: <b><?=number_format($order->order_amount,2)?> руб.</b></p>
        <hr>
        <p>Наши менеджеры свяжутся с Вами в ближайшее время.</p>
        <div class="text-right">
            <a class="btn btn-primary btn-flat" href="<?=\yii\helpers\Url::to(['site/index'])?>">Продолжить покупки</a>
        </div>
    </div>
</div>
