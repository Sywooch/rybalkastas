<?php
 use yii\widgets\Menu;
 use yii\widgets\ActiveForm;
?>

<footer class="describtion-block">
    <div class="container top-footer hidden-xs">
        <div class="row">
            <div class="col-md-4">
                <div class="subscribe">
                    <p>Будьте в курсе последних новинок на РыбалкаShop!</p>
                    <?php
                    $model = new \common\models\SubscribedMails();
                    $form = ActiveForm::begin(['action'=>'/site/subscribe']);
                    ?>
                        <?=$form->field($model, 'email')->textInput(['placeholder'=>'Ваш Email'])->label(false)?>
                        <input type="submit" value="Подписаться">
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-5">

            </div>
            <div class="col-md-3 payment-block">
                <p>Мы принимаем</p>
                <img alt="платежные системы"  src="/img/payments.png">
            </div>
        </div>
    </div>
</footer>
<div class="container">
    <div class="row">
    <footer class="footer-bs">

            <div class="col-md-3 footer-brand">
                <img src="/img/logo-footer-black.png"/>
                <p>По любым вопросам связанным с работой интернет-магазина обращайтесь:</p>
                <p>
                    <i class="fa fa-phone"></i> Москва, Россия: +7 (499) 707-11-14
                </p>
                <p>
                    <i class="fa fa-envelope"></i> E-mail: contacts@rybalkashop.ru
                </p>
                <br/>
                <p>2006 - <?=date('Y')?> | © Rybalkashop.ru</p>
            </div>
            <div class="col-md-5 footer-nav">
                <div class="col-md-6">
                    <h4>О компании —</h4>
                    <?=Menu::widget([
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
                    ]);?>

                </div>
                <div class="col-md-6">
                    <h4>Доставка и оплата —</h4>
                    <?=Menu::widget([
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
                    ]);?>
                </div>
            </div>
            <div class="col-md-4 footer-nav">
                <div class="col-md-6">
                    <h4>Товары —</h4>
                    <?=Menu::widget([
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
                    ]);?>
                </div>
                <div class="col-md-6">
                    <h4>&nbsp;</h4>
                    <?=Menu::widget([
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
                    ]);?>
                </div>
            </div>

    </footer>
    </div>


</div>