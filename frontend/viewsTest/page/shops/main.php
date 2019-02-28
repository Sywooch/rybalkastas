<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.03.2017
 * Time: 14:50
 */




$this->title = "Контакты";
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="expage">

    <h1 class="page-header text-center">
        Магазины &laquo;Рыболов на Птичке&raquo;
    </h1>
    <div class="headblock">
        <img src="/img/rsnew.png"/>
        <div class="shop-info">
            <span class="shop-name">Телефон интернет-магазина:</span><br/>
            <span class="shop-phone">+7 499 707-11-14</span><br/>
            <span class="shop-email">Email: <a href="mailto:contacts@rybalkashop.ru">contacts@rybalkashop.ru</a></span>
            <br/><br/>
        </div>
        <br/><br/>
    </div>

    <div class="shops_grid">
        <a href="<?=\yii\helpers\Url::to(['/page/shops', 'shop'=>'bratislavskaya'])?>" class="shop_item col-md-6" style="background-image: url(/img/shops/brat.jpg)">
            <div class="shop_heading">Братиславская</div>
            <div class="shop_info">
                <span class="addr">г. Москва, ул. Перерва д.39</span>
                <span class="phone">+7 499 707-11-55</span>
                <span class="phone">+7-(917)-578-15-79</span>
            </div>
            <div class="shop_overlay"></div>
        </a>
        <a href="<?=\yii\helpers\Url::to(['/page/shops', 'shop'=>'ptichka1'])?>" class="shop_item col-md-6" style="background-image: url(/img/shops/pav1.jpg)">
            <div class="shop_heading">Рыболовия - Птичий рынок</div>
            <div class="shop_info">
                <span class="addr">г. Москва, 14 км МКАД (терр-ия рынка Садовод)</span>
                <span class="phone">+7-(499)-707-11-33</span>
                <span class="phone">+7-(919)-764-35-41</span>
            </div>
            <div class="shop_overlay"></div>
        </a>
        <a href="<?=\yii\helpers\Url::to(['/page/shops', 'shop'=>'ptichka2'])?>" class="shop_item col-md-6" style="background-image: url(/img/shops/pav2.jpg)">
            <div class="shop_heading">Рыболов на Птичке - Птичий рынок</div>
            <div class="shop_info">
                <span class="addr">г. Москва, 14 км МКАД (терр-ия рынка Садовод)</span>
                <span class="phone">+7-(499)-707-11-88</span>
                <span class="phone">+7-(916)-268-77-13</span>
            </div>
            <div class="shop_overlay"></div>
        </a>
        <a href="<?=\yii\helpers\Url::to(['/page/shops', 'shop'=>'dzerzhinskiy'])?>" class="shop_item col-md-6" style="background-image: url(/img/shops/dzer.jpg)">
            <div class="shop_heading">16 км МКАД, г. Дзержинский</div>
            <div class="shop_info">
                <span class="addr">16 км МКАД, г. Дзержинский, ул. Энергетиков д.16с1</span>
                <span class="phone">+7-(499)-707-11-15</span>
                <span class="phone">+7-(926)-783-33-14</span>
            </div>
            <div class="shop_overlay"></div>
        </a>
        <div class="clearfix"></div>
    </div>
</div>

<div class="expage_blue_block">
    <p class="text-info">ИП «Русяев Максим Васильевич»</p>
    <p class="text-info">ОГРНИП: 305504216100028</p>
    <p class="text-info">Фактический адрес: г. Москва, ул. Перерва, 39</p>
    <p class="text-info">Юридический адрес: 141315 Московская обл. г. Сергиев Посад, Кукуевская наб. 7</p>
</div>