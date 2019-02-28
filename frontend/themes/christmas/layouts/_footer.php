<?php

use yii\widgets\Menu;
use yii\widgets\ActiveForm;

$model = new \common\models\SubscribedMails();

?>

<footer class="describtion-block">
    <div class="container top-footer hidden-xs">
        <div class="row">
            <div class="col-md-5">
                <div class="subscribe row">
                    <div class="col-xs-12">
                        <p style="text-transform: uppercase">Будьте в курсе последних новинок на РыбалкаShop!</p>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'action'=>'/site/subscribe',
                        'fieldConfig' => [
                            'template' => "{input}"
                        ]
                    ]); ?>

                    <div class="col-xs-7">
                        <?= $form->field($model, 'email')
                            ->textInput(['placeholder'=>'Ваш Email'])
                            ->label(false) ?>
                    </div>

                    <div class="col-xs-5">
                        <input type="submit" value="Подписаться">
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <p style="text-transform: uppercase">Мы в соц.сетях</p>
                <ul class="list-inline list-social-icon">
                    <li>
                        <a href="//vk.com/rybalkashop_naptichke" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="50" height="50"
                                 viewBox="0 0 48 48"
                                 style="fill:#000000;">
                                <g id="surface1">
                                    <path style=" fill:#0288D1;" d="M 42 37 C 42 39.761719 39.761719 42 37 42 L 11 42 C 8.238281 42 6 39.761719 6 37 L 6 11 C 6 8.238281 8.238281 6 11 6 L 37 6 C 39.761719 6 42 8.238281 42 11 Z "></path>
                                    <path style=" fill:#FFFFFF;" d="M 33.183594 27.359375 C 35.265625 29.308594 35.699219 30.261719 35.769531 30.378906 C 36.628906 31.824219 34.816406 31.9375 34.816406 31.9375 L 31.34375 31.988281 C 31.34375 31.988281 30.59375 32.136719 29.613281 31.453125 C 28.3125 30.554688 26.535156 28.210938 25.582031 28.515625 C 24.613281 28.824219 24.921875 31.28125 24.921875 31.28125 C 24.921875 31.28125 24.929688 31.582031 24.710938 31.824219 C 24.46875 32.078125 24 31.980469 24 31.980469 L 23 31.980469 C 23 31.980469 19.292969 31.996094 16.269531 28.816406 C 12.976563 25.351563 10.222656 18.871094 10.222656 18.871094 C 10.222656 18.871094 10.054688 18.460938 10.234375 18.242188 C 10.441406 17.996094 11 18 11 18 L 14.714844 18 C 14.714844 18 15.0625 18.046875 15.3125 18.234375 C 15.523438 18.386719 15.636719 18.675781 15.636719 18.675781 C 15.636719 18.675781 16.085938 19.882813 16.882813 21.273438 C 18.433594 23.984375 19.15625 24.578125 19.683594 24.285156 C 20.449219 23.859375 20.21875 20.453125 20.21875 20.453125 C 20.21875 20.453125 20.234375 19.214844 19.832031 18.664063 C 19.519531 18.234375 18.9375 18.109375 18.679688 18.074219 C 18.46875 18.050781 18.8125 17.558594 19.257813 17.339844 C 19.925781 17.011719 21.109375 16.988281 22.503906 17.003906 C 23.589844 17.015625 24 17 24 17 C 25.28125 17.3125 24.847656 18.523438 24.847656 21.414063 C 24.847656 22.34375 24.679688 23.648438 25.34375 24.078125 C 25.628906 24.269531 26.652344 24.296875 28.390625 21.308594 C 29.21875 19.890625 29.871094 18.558594 29.871094 18.558594 C 29.871094 18.558594 30.011719 18.257813 30.21875 18.132813 C 30.4375 18 30.726563 18 30.726563 18 L 34.636719 18.019531 C 34.636719 18.019531 35.8125 17.871094 36 18.410156 C 36.199219 18.972656 35.519531 19.957031 33.925781 22.109375 C 31.300781 25.644531 31.007813 25.316406 33.183594 27.359375 Z "></path>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="//www.facebook.com/rybalkashop.ru" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="50" height="50"
                                 viewBox="0 0 48 48"
                                 style="fill:#000000;">
                                <g id="surface1">
                                    <path style=" fill:#3F51B5;" d="M 42 37 C 42 39.761719 39.761719 42 37 42 L 11 42 C 8.238281 42 6 39.761719 6 37 L 6 11 C 6 8.238281 8.238281 6 11 6 L 37 6 C 39.761719 6 42 8.238281 42 11 Z "></path>
                                    <path style=" fill:#FFFFFF;" d="M 34.367188 25 L 31 25 L 31 38 L 26 38 L 26 25 L 23 25 L 23 21 L 26 21 L 26 18.589844 C 26.003906 15.082031 27.460938 13 31.59375 13 L 35 13 L 35 17 L 32.714844 17 C 31.105469 17 31 17.601563 31 18.722656 L 31 21 L 35 21 Z "></path>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="//www.instagram.com/rybalkashop_ru/" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                 width="50" height="50"
                                 viewBox="0 0 48 48"
                                 style="enable-background:new 0 0 48 48;;fill:#000000;">
                                <g id="surface1">
                                    <path style="fill:#304FFE;" d="M32,42H16c-5.5,0-10-4.5-10-10V16c0-5.5,4.5-10,10-10h16c5.5,0,10,4.5,10,10v16   C42,37.5,37.5,42,32,42z"></path>
                                    <path style="fill:#304FFE;fill-opacity:0.2902;" d="M6,16v16c0,5.5,4.5,10,10,10h16c5.5,0,10-4.5,10-10V16c0-1-0.1-1.9-0.4-2.8   C36,8.7,28.8,6,21,6c-3.7,0-7.3,0.6-10.7,1.8C7.7,9.6,6,12.6,6,16z"></path>
                                    <path style="fill:#6200EA;" d="M21,8c-5,0-9.6,1.2-13.8,3.2C6.4,12.7,6,14.3,6,16v16c0,5.5,4.5,10,10,10h16c5.5,0,10-4.5,10-10   V16.2C36.5,11.1,29.1,8,21,8z"></path>
                                    <path style="fill:#673AB7;" d="M42,19c-5.3-5.5-12.7-9-21-9c-5.4,0-10.5,1.5-14.8,4.1C6.1,14.7,6,15.3,6,16v16c0,5.5,4.5,10,10,10   h16c5.5,0,10-4.5,10-10V19z"></path>
                                    <path style="fill:#8E24AA;" d="M42,22c-4.9-6.1-12.5-10-21-10c-5.6,0-10.7,1.7-15,4.6V32c0,5.5,4.5,10,10,10h16c5.5,0,10-4.5,10-10   V22z"></path>
                                    <path style="fill:#C2185B;" d="M42,32v-6.6C37.5,18.6,29.8,14,21,14c-5.6,0-10.8,1.9-15,5v13c0,5.5,4.5,10,10,10h16   C37.5,42,42,37.5,42,32z"></path>
                                    <path style="fill:#D81B60;" d="M42,32v-2.4C38.4,21.6,30.4,16,21,16c-5.7,0-11,2.1-15,5.6V32c0,5.5,4.5,10,10,10h16   C37.5,42,42,37.5,42,32z"></path>
                                    <path style="fill:#F50057;" d="M41.6,34.8C39.7,25.2,31.2,18,21,18c-5.9,0-11.2,2.4-15,6.3V32c0,5.5,4.5,10,10,10h16   C36.5,42,40.4,39,41.6,34.8z"></path>
                                    <path style="fill:#FF1744;" d="M39.9,38C39.4,28,31.2,20,21,20c-6.1,0-11.5,2.9-15,7.4V32c0,5.5,4.5,10,10,10h16   C35.2,42,38.1,40.4,39.9,38z"></path>
                                    <path style="fill:#FF5722;" d="M21,22c-6.5,0-12.1,3.6-15,9v1c0,5.5,4.5,10,10,10h16c2.2,0,4.3-0.7,5.9-2c0-0.3,0.1-0.7,0.1-1   C38,29.6,30.4,22,21,22z"></path>
                                    <path style="fill:#FF6F00;" d="M21,24c-7,0-12.8,4.7-14.5,11.2c1.3,4,5.1,6.8,9.5,6.8h16c1.4,0,2.6-0.3,3.8-0.8   c0.1-0.7,0.2-1.5,0.2-2.2C36,30.7,29.3,24,21,24z"></path>
                                    <path style="fill:#FF9800;" d="M21,26c-6.9,0-12.5,5.3-12.9,12c1.8,2.4,4.7,4,7.9,4h16c0.6,0,1.1-0.1,1.7-0.2   C33.9,40.9,34,40,34,39C34,31.8,28.2,26,21,26z"></path>
                                    <path style="fill:#FFC107;" d="M31.6,42c0.3-1,0.4-2,0.4-3c0-6.1-4.9-11-11-11s-11,4.9-11,11c0,0.3,0,0.7,0.1,1   c1.7,1.2,3.7,2,5.9,2H31.6z"></path>
                                    <path style="fill:#FFD54F;" d="M21,30c-5,0-9,4-9,9c0,0.8,0.1,1.6,0.3,2.3c1.1,0.5,2.4,0.7,3.7,0.7h13.5c0.3-0.9,0.5-1.9,0.5-3   C30,34,26,30,21,30z"></path>
                                    <path style="fill:#FFE082;" d="M21,32.1c-3.9,0-7,3.1-7,7c0,1,0.2,1.9,0.6,2.8C15.1,42,15.5,42,16,42h11.4c0.4-0.9,0.6-1.9,0.6-2.9   C28,35.2,24.9,32.1,21,32.1z"></path>
                                    <path style="fill:#FFECB3;" d="M21,34.1c-2.8,0-5,2.2-5,5c0,1.1,0.4,2.1,1,2.9H25c0.6-0.8,1-1.8,1-2.9C26,36.3,23.8,34.1,21,34.1z"></path>
                                    <path style="fill:#FFFFFF;" d="M30,38H18c-4.4,0-8-3.6-8-8V18c0-4.4,3.6-8,8-8h12c4.4,0,8,3.6,8,8v12C38,34.4,34.4,38,30,38z    M18,12c-3.3,0-6,2.7-6,6v12c0,3.3,2.7,6,6,6h12c3.3,0,6-2.7,6-6V18c0-3.3-2.7-6-6-6H18z"></path>
                                    <path style="fill:#FFFFFF;" d="M24,31c-3.9,0-7-3.1-7-7c0-3.9,3.1-7,7-7c3.9,0,7,3.1,7,7C31,27.9,27.9,31,24,31z M24,19   c-2.8,0-5,2.2-5,5s2.2,5,5,5s5-2.2,5-5S26.8,19,24,19z"></path>
                                    <path style="fill:#FFFFFF;" d="M32,16c0,0.6-0.4,1-1,1s-1-0.4-1-1s0.4-1,1-1S32,15.4,32,16z"></path>
                                </g>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 payment-block">
                <p style="text-transform: uppercase">Мы принимаем</p>
                <img alt="платежные системы"  src="/img/payments.png">
            </div>
        </div>
    </div>
</footer>

<div class="container">
    <div class="row">
        <footer class="footer-bs">
            <div class="col-md-3 footer-brand">
                <img src="/img/logo-footer-white.png"/>
                <p>По любым вопросам связанным с работой интернет-магазина обращайтесь:</p>
                <p><i class="fa fa-phone"></i> Москва, Россия: +7 (499) 707-11-14</p>
                <p><i class="fa fa-envelope"></i> E-mail: contacts@rybalkashop.ru</p>

                <br/>

                <p>2006 - <?=date('Y')?> | © Rybalkashop.ru</p>
            </div>

            <div class="col-md-5 footer-nav">
                <div class="col-md-6">
                    <h4>О компании —</h4>

                    <?= Menu::widget([
                        'items'=>[
                            ['label'=>'О нас', 'url'=>['/page/index', 'slug'=>'o-nas']],
                            ['label'=>'Наши магазины', 'url'=>['/page/index', 'slug'=>'shops']],
                            ['label'=>'Консультация', 'url'=>['/experts/index']],
                            ['label'=>'Новости', 'url'=>['/news/index']],
                        ],
                        'options'=> [
                            'class'=>'list'
                        ],
                        'encodeLabels'=>false,
                    ]) ;?>
                </div>

                <div class="col-md-6">
                    <h4>Доставка и оплата —</h4>

                    <?= Menu::widget([
                        'items'=>[
                            ['label'=>'Как купить', 'url'=>['/page/index', 'slug'=>'kak-zakazat']],
                            ['label'=>'Доставка', 'url'=>['/page/index', 'slug'=>'dostavka']],
                            ['label'=>'Оплата', 'url'=>['/page/index', 'slug'=>'sposoby-oplaty']],
                            ['label'=>'Скидки и акции', 'url'=>['/page/index', 'slug'=>'skidki-i-akcii']],
                        ],
                        'options'=> [
                            'class'=>'list'
                        ],
                        'encodeLabels'=>false,
                    ]); ?>
                </div>
            </div>

            <div class="col-md-4 footer-nav">
                <div class="col-md-6">
                    <h4>Товары —</h4>

                    <?= Menu::widget([
                        'items'=>[
                            ['label'=>'Катушки', 'url'=>['/shop/category', 'id'=>'443']],
                            ['label'=>'Удилища', 'url'=>['/shop/category', 'id'=>'1653']],
                            ['label'=>'Лески/Шнуры', 'url'=>['/shop/category', 'id'=>'557']],
                            ['label'=>'Приманки', 'url'=>['/shop/category', 'id'=>'444']],
                        ],
                        'options'=> [
                            'class'=>'list'
                        ],
                        'encodeLabels'=>false,
                    ]); ?>
                </div>

                <div class="col-md-6">
                    <h4>&nbsp;</h4>

                    <?= Menu::widget([
                        'items'=>[
                            ['label'=>'Одежда', 'url'=>['/shop/category', 'id'=>'3345']],
                            ['label'=>'Обувь', 'url'=>['/shop/category', 'id'=>'254']],
                            ['label'=>'Очки', 'url'=>['/shop/category', 'id'=>'5103']],
                            ['label'=>'Забродная ам-ция', 'url'=>['/shop/category', 'id'=>'8423']],
                        ],
                        'options'=> [
                            'class'=>'list'
                        ],
                        'encodeLabels'=>false,
                    ]); ?>
                </div>
            </div>
        </footer>
    </div>
</div>
