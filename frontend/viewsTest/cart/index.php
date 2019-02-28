<?php

use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;

$this->title = "Корзина";
$this->params['breadcrumbs'][] = $this->title;

$cart = Yii::$app->cart;

$minPriceInt = Yii::$app->settings->get('cart', 'minprice')-(empty(\Yii::$app->session->get('certificateID'))?0:Yii::$app->settings->get('cart', 'minprice'));

?>


    <div class="text-center">
        <h1 class="page-header">Корзина</h1>
    </div>

    <div class="text-right">
        <a class="btn btn-flat btn-warning" href="<?= \yii\helpers\Url::to(Yii::$app->request->referrer) ?>"><i
                    class="fa fa-chevron-left"></i> Вернуться</a>
        <?php if (!Yii::$app->user->isGuest): ?>
            <a class="btn btn-flat btn-info" href="<?= \yii\helpers\Url::to(['/user/settings/laterproducts']) ?>"><i
                        class="fa fa-clock-o"></i> Отложенные товары</a>
        <?php endif; ?>
        <a class="btn btn-flat btn-danger clearCart" href="<?= \yii\helpers\Url::to(['clear']) ?>"><i class="fa fa-times"></i>
            Очистить корзину</a>
    </div>

    <div class="row" id="cart_products_row">

        <div class="col-md-12">

            <?= $this->render('_cart_products', ['certForm' => $certForm]); ?>


        </div>

    </div>
<?php $form = ActiveForm::begin(['id'=>'cartForm']); ?>
    <div class="row">
    <div class="col-md-6">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Данные о покупателе</h5>
            </div>
            <div class="ibox-content">
                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'city')->widget(\kartik\select2\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\SCCities::find()->orderBy('cityName')->all(),'cityID','cityName'),
                    'options' => ['placeholder' => 'Выбрать город'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
                <?= $form->field($model, 'street') ?>
                <?= $form->field($model, 'house') ?>
                <?= $form->field($model, 'comment')->textarea() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">


        <div class="ibox">
            <div class="ibox-title">
                <h5>Доставка и оплата</h5>
            </div>
            <div class="ibox-content">

                <?= $form->field($model, 'shipping')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\SCShippingMethods::find()->orderBy('sort_order')->all(), 'SID', 'Name_ru'), ['id' => 'shipping_id', 'prompt' => 'Выбрать способ доставки']); ?>

                <?= $form->field($model, 'payment')->widget(DepDrop::classname(), [
                    'options' => ['id' => 'payment_id'],
                    'pluginOptions' => [
                        'depends' => ['shipping_id'],
                        'placeholder' => 'Выбрать способ оплаты',
                        'url' => \yii\helpers\Url::to(['check-shipping']),
                        'initialize'=>true,
                    ]
                ]); ?>

                <?= $form->field($model, 'manager')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\SCExperts::find()->orderBy('expert_fullname')->all(), 'expert_id', 'expert_fullname'), ['prompt' => 'Не выбирать']) ?>

            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Помощь</h5>
            </div>
            <div class="ibox-content text-center">
                <b><i class="fa fa-phone"></i> + 7 (499) 707-11-14</b><br/>
                <span class="small">
                        Свяжитесь с нами если у вас возникли какие-либо вопросы.
                    </span>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Подтверждение</h5>
            </div>
            <div class="ibox-content">
                <?= $form->field($model, 'accept_policy', ['template' => "<div class=\"\">\n{input}\nЯ ознакомился с <a href='".\yii\helpers\Url::to(['/page/index', 'slug'=>'public_offer'])."'>договором публичной оферты</a> и <a href='".\yii\helpers\Url::to(['/page/index', 'slug'=>'privacy_policy'])."'>политикой конфиденциальности</a>\n{error}\n{hint}\n</div>"])->checkbox(['uncheck'=>null]);?>
                <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::className())->hint('Нажмите на изображение с кодом, чтобы изменить его') ?>
                <input type="hidden" id="currentSum" value="<?=$cart->getCost()?>"/>

                <div class="pull-right"><span>Сумма заказа:</span> <b
                            class="cart-sum-accept"><?= number_format($cart->getCost(), 2) ?> руб.</b></div>
                <hr>
                <div class="minpricemsg text-center"><?php if($cart->getCost() < $minPriceInt)echo Yii::$app->settings->get('cart', 'minpricemsg');?></div>

                <button id="sendOrder" class="btn btn-primary btn-flat pull-right"<?php if($cart->getCost() < $minPriceInt)echo ' disabled';?>><i class="fa fa fa-shopping-cart"></i> Оформить
                    заказ
                </button>
                <button id="sendOrderDisabled" class="hidden btn btn-primary btn-flat pull-right" disabled="disabled" type="button">
                    <i class="fa fa-spinner fa-spin fa-fw"></i> Заказ оформляется...
                </button>
                <a href="/" class="btn btn-default btn-flat hidden"><i class="fa fa-arrow-left"></i> Вернуться в магазин</a>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>

    </div>
<?php ActiveForm::end(); ?>


<?php

$minprice = $minPriceInt;
$minpricemsg = Yii::$app->settings->get('cart', 'minpricemsg');

$js = <<< JS
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
            } else {
                $('.minpricemsg').html(minpricemsg);
                $('#sendOrder').prop('disabled', true);
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
            } else {
                $('.minpricemsg').html(minpricemsg);
                $('#sendOrder').prop('disabled', true);
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
                } else {
                    $('.minpricemsg').html(minpricemsg);
                    $('#sendOrder').prop('disabled', true);
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



$('#cartForm').on('beforeSubmit', function (e) {
    $(this).find('#sendOrder').remove();
    $(this).find('#sendOrderDisabled').removeClass('hidden');
});

JS;
$this->registerJs($js);
?>