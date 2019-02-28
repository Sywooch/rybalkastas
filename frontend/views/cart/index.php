<?php

/* @var $model OrderingForm */
/* @var $modelQuick \frontend\models\OrderingFormQuick */
/* @var $shippingMethods \common\models\SCShippingMethods|array */
/* @var $cities \common\models\SCCities|array */
/* @var $experts SCExperts|array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use common\models\SCExperts;
use frontend\models\OrderingForm;
use common\services\PhoneService;


$this->title = "Корзина";
$this->params['breadcrumbs'][] = $this->title;

$cart = Yii::$app->cart;

$minPriceInt = Yii::$app->settings->get('cart', 'minprice') - (empty(\Yii::$app->session->get('certificateID')) ? 0 : Yii::$app->settings->get('cart', 'minprice'));

?>

<div class="text-center">
    <h1 class="page-header">Корзина</h1>
</div>

<div class="row">
    <div class="col-md-12 text-right">
        <a class="btn btn-flat btn-warning" href="<?= Url::to(Yii::$app->request->referrer) ?>">
            <i class="fa fa-chevron-left"></i> Вернуться
        </a>

        <?php if (!Yii::$app->user->isGuest): ?>
            <a class="btn btn-flat btn-info" href="<?= Url::to(['/user/settings/laterproducts']) ?>">
                <i class="fa fa-clock-o"></i> Отложенные товары
            </a>

            <a class="btn btn-flat purple-sharp" href="<?= Url::to(['/user/settings/requestedproducts']) ?>">
                <i class="fa fa-bell"></i> Ожидаемые товары <span class="badge badge-pill badge-danger">
                    <?= Yii::$app->user->identity->customer->requestedCount ?></span>
            </a>
        <?php endif; ?>

        <a class="btn btn-flat btn-danger clearCart" href="<?= Url::to(['clear']) ?>">
            <i class="fa fa-times"></i>Очистить корзину
        </a>
    </div>
</div>

<div class="row" id="cart_products_row">
    <div class="col-md-12">
        <?= $this->render('_cart_products', ['certForm' => $certForm]); ?>
    </div>
</div>

<ul class="nav nav-tabs" id="cartTabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#main" aria-controls="main" role="tab" data-toggle="tab">Заказ</a>
    </li>
    <li role="presentation">
        <a href="#quick" aria-controls="quick" role="tab" data-toggle="tab">
            <b class="text-danger"><i class="fa fa-clock-o"></i> Быстрый заказ</b>
        </a>
    </li>
</ul>

<div class="tab-content" id="order_tabs">
    <div role="tabpanel" class="tab-pane active" id="main">
        <?php $form = ActiveForm::begin([
            'id' => 'cartForm',
            'action' => Url::to(['/cart/create-order']),
            'validationUrl' => Url::to(['/cart/order-form-validate']),
            'enableAjaxValidation' => true,
        ]); ?>
        <div class="row">
            <div class="col-md-6">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Данные о покупателе</h5>
                    </div>
                    <div class="ibox-content">
                        <?= $form->field($model, 'first_name') ?>
                        <?= $form->field($model, 'last_name') ?>
                        <?= $form->field($model, 'patron_name') ?>
                        <?= $form->field($model, 'phone', [
                            'addon' => [
                                'prepend' => [
                                    'asButton' => true,
                                    'content' => Html::dropDownList($model->className . '[phonecode]',
                                        PhoneService::RUSSIA_ISO3166,
                                        PhoneService::getCodesDescription(), [
                                            'class' => 'input-group-selected btn btn-default dropdown-toggle',
                                            'id'    => 'phonecode'
                                        ]
                                    ),
                                ],
                            ],
                        ])->textInput(['autocomplete' => 'off']); ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'city')->widget(\kartik\select2\Select2::classname(), [
                            'data' => ArrayHelper::map($cities, 'cityID', 'cityName'),
                            'options' => ['placeholder' => 'Выбрать город'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);  ?>
                        <?= $form->field($model, 'street') ?>

                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <?= $form->field($model, 'house') ?>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <?= $form->field($model, 'flat') ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'zip') ?>
                        <?= $form->field($model, 'comment')->textarea()->label('Комментарий к заказу') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Доставка и оплата</h5>
                    </div>
                    <div class="ibox-content">
                        <?php $shippingData = [];

                        foreach ($shippingMethods as $shipping):
                            if ($shipping->shop_id)
                                $shippingData[$shipping->SID] = [
                                    'data-shop-id' => $shipping->shop_id
                                ];
                        endforeach; ?>

                        <?= $form->field($model, 'shipping')->dropDownList(ArrayHelper::map($shippingMethods,
                            'SID', 'Name_ru'), [
                                'id'      => 'shipping_id',
                                'prompt'  => 'Выбрать способ доставки',
                                'options' => $shippingData
                            ]); ?>

                        <div id="boxberry_inputs" style="display: none">
                            <?= $form->field($model, 'boxberry_info')->hiddenInput() ?>

                            <button onclick="boxberry.open('callback_bb'); return false;" type="button"
                                    class="btn btn-primary">Выбрать пункт самовывоза
                            </button>

                            <div style="display: none" id="boxberry_label"></div>

                            <br/>
                            <br/>
                        </div>

                        <?= $form->field($model, 'payment')->widget(DepDrop::classname(), [
                            'options' => ['id' => 'payment_id'],
                            'pluginOptions' => [
                                'depends' => ['shipping_id'],
                                'placeholder' => 'Выбрать способ оплаты',
                                'url' => Url::to(['check-shipping']),
                                'initialize' => true,
                            ]
                        ]); ?>

                        <?php $expertData = [];

                        foreach ($experts as $expert):
                            $expertData[$expert->expert_id] = [
                                'data-shop-id' => $expert->shop_id
                            ];
                        endforeach; ?>

                        <?= $form->field($model, 'manager')->dropDownList(ArrayHelper::map($experts,
                            'expert_id', 'expert_fullname'), [
                            'prompt'  => 'Не выбирать',
                            'options' => $expertData
                        ]) ?>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Помощь</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <b><i class="fa fa-phone"></i> + 7 (499) 707-11-14</b>

                        <br/>

                        <span class="small">Свяжитесь с нами если у вас возникли какие-либо вопросы.</span>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Подтверждение</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="hidden">
                            <?= $form->field($model, 'accept_policy')->hiddenInput(['value' => 1]) ?>
                        </div>

                        <?php if (false && Yii::$app->user->isGuest): ?>
                            <?php /* $form->field($model, 'accept_policy', [
                                    'template' => "<div class=\"\">\n{input}\nЯ ознакомился с <a href='".Url::to(['/page/index', 'slug'=>'public_offer'])."'>договором публичной оферты</a> и <a href='".Url::to(['/page/index', 'slug'=>'privacy_policy'])."'>политикой конфиденциальности</a>\n{error}\n{hint}\n</div>"
                            ])->checkbox(['uncheck'=>null]); */ ?>

                            <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::className())
                                ->hint('Чтобы изменить изображение с кодом - нажмите на него') ?>
                        <?php endif; ?>

                        <input type="hidden" id="currentSum" value="<?= $cart->getCost() ?>"/>

                        <p>Оформляя заказ, вы подтверждаете, что ознакомились с <a href="<?= Url::to(['/page/index', 'slug' => 'public_offer']) ?>">договором публичной оферты</a> и <a href="<?= Url::to(['/page/index', 'slug' => 'privacy_policy']) ?>">политикой конфиденциальности</a></p>

                        <br/>

                        <div class="pull-right"><span>Сумма заказа:</span> <b class="cart-sum-accept"><?= number_format($cart->getCost(), 2) ?> руб.</b></div>

                        <hr>

                        <div class="minpricemsg text-center"><?php if ($cart->getCost() < $minPriceInt) echo Yii::$app->settings->get('cart', 'minpricemsg'); ?></div>

                        <button id="sendOrder" class="btn btn-primary btn-flat pull-right" <?php if ($cart->getCost() < $minPriceInt) echo ' disabled'; ?>>
                            <i class="fa fa fa-shopping-cart"></i> Оформить заказ
                        </button>

                        <button id="sendOrderDisabled" class="hidden btn btn-primary btn-flat pull-right" disabled="disabled" type="button">
                            <i class="fa fa-spinner fa-spin fa-fw"></i> Заказ оформляется...
                        </button>

                        <a href="/" class="btn btn-default btn-flat hidden"><i class="fa fa-arrow-left"></i>Вернуться в магазин</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div role="tabpanel" class="tab-pane" id="quick">
        <?php $form = ActiveForm::begin([
            'id' => 'cartFormQ',
            'action' => Url::to(['/cart/create-quick-order']),
            'validationUrl' => Url::to(['/cart/order-quick-form-validate']),
            'enableAjaxValidation' => true,
        ]); ?>
        <div class="ibox">
            <div class="ibox-title">
                <h5>Данные о покупателе</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <?= $form->field($modelQuick, 'first_name') ?>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <?= $form->field($modelQuick, 'last_name') ?>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <?= $form->field($modelQuick, 'email') ?>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <?= $form->field($modelQuick, 'phone', [
                            'addon' => [
                                'prepend' => [
                                    'asButton' => true,
                                    'content' => Html::dropDownList($modelQuick->className . '[phonecode]',
                                        PhoneService::RUSSIA_ISO3166,
                                        PhoneService::getCodesDescription(), [
                                            'class' => 'input-group-selected btn btn-default dropdown-toggle',
                                            'id'    => 'phonecode_quick'
                                        ]
                                    ),
                                ],
                            ],
                        ])->textInput(['autocomplete' => 'off']); ?>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <?= $form->field($modelQuick, 'shipping')->dropDownList(ArrayHelper::map($shippingMethods,
                            'SID', 'Name_ru'), [
                            'id'     => 'shipping_id',
                            'prompt' => 'Выбрать способ доставки'
                        ]); ?>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <p>Оформляя заказ, вы подтверждаете, что ознакомились с <a href="<?= Url::to(['/page/index', 'slug' => 'public_offer']) ?>">договором публичной оферты</a> и <a href="<?= Url::to(['/page/index', 'slug' => 'privacy_policy']) ?>">политикой конфиденциальности</a></p>

                        <br/>

                        <div class="pull-right"><span>Сумма заказа:</span> <b class="cart-sum-accept"><?= number_format($cart->getCost(), 2) ?> руб.</b></div>

                        <hr>

                        <div class="minpricemsg text-center"><?php if ($cart->getCost() < $minPriceInt) echo Yii::$app->settings->get('cart', 'minpricemsg'); ?></div>

                        <button id="sendOrderQuick" class="btn btn-primary btn-flat pull-right"<?php if ($cart->getCost() < $minPriceInt) echo ' disabled'; ?>>
                            <i class="fa fa fa-shopping-cart"></i> Оформить заказ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php

$minprice = $minPriceInt;
$minpricemsg = Yii::$app->settings->get('cart', 'minpricemsg');

$phoneMaskListJson = json_encode(PhoneService::getPhoneMask());

$js = <<< JS
var phone = document.getElementById("orderingform-phone");
var phone_quick = document.getElementById("orderingformquick-phone");

$('#cart_products_row').on('click', '.item-manipulation:not(.removeItem)' , function(e){
    e.preventDefault();
    
    var link = $(this);
    var minprice = $minprice;
    var minpricemsg = "$minpricemsg";
    
    $.ajax({
        type: "get",
        url: link.attr('href'),
        dataType: 'json',
        success: function(data)
        {
            link.closest('tr').replaceWith(data.tr);
            $('.cart-sum-accept, #cart-sum').html(data.sum);
            $('.cart_count').html(data.count);
            $('#cart_msg').html(data.msg);
            
            if(data.sum_int >= minprice){
                $('.minpricemsg').html('');
                $('#sendOrder').removeAttr('disabled');
                $('#sendOrderQuick').removeAttr('disabled');
            } else {
                $('.minpricemsg').html(minpricemsg);
                $('#sendOrder').prop('disabled', true);
                $('#sendOrderQuick').prop('disabled', true);;
            }
            
        }
    });
}).on('click', '.addLater', function(e){
    e.preventDefault();
    var link = $(this); 
    $.ajax({
        type: "get",
        url: link.attr('href'),
        dataType: 'json',
        success: function(data)
        {
            link.closest('tr').remove();
            $('.cart-sum-accept, #cart-sum').html(data.sum);
            $('.cart_count').html(data.count);
            $('#cart_msg').html(data.msg);
            
            if(data.sum_int >= minprice){
                $('.minpricemsg').html('');
                $('#sendOrder').removeAttr('disabled');
                $('#sendOrderQuick').removeAttr('disabled');
            } else {
                $('.minpricemsg').html(minpricemsg);
                $('#sendOrder').prop('disabled', true);
                $('#sendOrderQuick').prop('disabled', true);
            }
        }
    });
}).on('click', '.item-manipulation.removeItem' , function(e){
        e.preventDefault();
        
        var link = $(this); 
        
        swal({
          title: 'Удалить товар?',
          text: "Данный товар удалится из корзины!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Удалить',
          cancelButtonText: 'Отменить'
        }).then(function () {
          swal(
            'Успешно!',
            'Товар успешно удален из корзины.',
            'success'
          );
          $.ajax({
            type: "get",
            url: link.attr('href'),
            dataType: 'json',
            success: function(data)
            {
                link.closest('tr').replaceWith(data.tr);
                $('.cart-sum-accept, #cart-sum').html(data.sum);
                $('.cart_count').html(data.count);
                $('#cart_msg').html(data.msg);
                
                if(data.sum_int >= minprice){
                    $('.minpricemsg').html('');
                    $('#sendOrder').removeAttr('disabled');
                    $('#sendOrderQuick').removeAttr('disabled');
                } else {
                    $('.minpricemsg').html(minpricemsg);
                    $('#sendOrder').prop('disabled', true);
                    $('#sendOrderQuick').prop('disabled', true);
                }
            }
            });
        });
    });

$('.clearCart').click(function(e){
    e.preventDefault();
    
    var link = $(this); 
        
    swal({
        title: 'Очистить корзину?',
        text: "Все товары удалятся из корзины!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Очистить',
        cancelButtonText: 'Отменить'
    }).then(function () {
        swal(
            'Успешно!',
            'Корзина очищена.',
            'success'
        );
        window.location.href = link.attr('href');
    });
});

$('#shipping_id').change(function(e){
    if ($(this).val() == 34) {
        $('#boxberry_inputs').show();
    } else {
        $('#boxberry_inputs').hide();
    }
    
    $('#orderingform-manager option:hidden').show();
    
    var shopID = $(this).find(':selected').attr('data-shop-id');
    
    if (shopID) {
        $('#orderingform-manager option[selected = selected]').attr('selected', false);
        $('#orderingform-manager option:selected').attr('selected', false);
        
        $('#orderingform-manager option[value = ""]').attr('selected', true);
        
        $('#orderingform-manager option[value != ""]:not([data-shop-id = ' + shopID + '])').hide();
    };
    
    if ($(this).val() == 20){
        swal({
            title: 'Внимание',
            html: '<p>После оформления заказа, Вы можете в любой день, <b>кроме дня доставки</b>, связаться с менеджером Интернет-магазина и назвав номер заказа:</p><br>' +
                  '<ul>' +
                    '<li>- изменить время и адрес доставки</li>' +
                    '<li>- добавить или отказаться от части товаров</li>' +
                    '<li>- отменить Ваш заказ</li>' +
                  '</ul>' + 
                  '<br><p style="color: red;">В день доставки частичный отказ от заказа невозможен!</p>',
            type: 'warning',
        })
    }
});

$('#payment_id').change(function(e){
    if($('#shipping_id').val() == 20 && $(this).val() == 14){
        swal({
            title: 'Внимание',
          text: "Курьеры не имеют при себе терминалы. Оплата банковской картой возможна только по предоплате.",
          type: 'warning',
        })
    }
});

$('#cartForm').on('beforeSubmit', function (e) {
    $(this).find('#sendOrder').remove();
    $(this).find('#sendOrderDisabled').removeClass('hidden');
});

var phoneMaskList = $phoneMaskListJson; //переменная инициализирована выше, перед началом JS

Inputmask(phoneMaskList[$('#phonecode').val()]).mask(phone);
Inputmask(phoneMaskList[$('#phonecode_quick').val()]).mask(phone_quick);

$('#phonecode').change(function(e) {
    Inputmask(phoneMaskList[$(this).val()]).mask(phone);
});

$('#phonecode_quick').change(function(e) {
    Inputmask(phoneMaskList[$(this).val()]).mask(phone_quick);
});

$('#order_tabs').on('paste','#orderingform-phone, #orderingformquick-phone', function(e){
    
});
JS;
$this->registerJs($js);

?>

<script type="text/javascript" src="http://points.boxberry.ru/js/boxberry.js"/></script>

<script>
function callback_bb(res) {
    $('#boxberry_label').html(res.address);
    $('#boxberry_label').show();
    $('#orderingform-boxberry_info').val(JSON.stringify(res));
}
</script>
