<?php
if(!empty($_GET['product'])){
    $model = \common\models\SCProducts::findOne($_GET['product']);
} elseif(!empty($_POST['AddToCartForm']['product'])){
    $model = \common\models\SCProducts::findOne($_POST['AddToCartForm']['product']);
} else {
    $model = \common\models\SCProducts::find()->where(['categoryID'=>$_GET['id']])->one();
}

?>


<?php if ($model->canAdd <> 1): ?>

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-block btn-warning text-uppercase btn-flat" type="submit"
                        data-toggle="modal" data-target="#subscribeModal">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    Сообщить о поступлении
                </button>

                <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                                <h2 class="text-center">Сообщить о поступлении</h2>
                            </div>
                            <div class="modal-body">
                                <div class="text-danger">Для использования этой функции, необходимо
                                    авторизоваться!
                                </div>
                                <hr/>
                                <?= $this->render('//_blocks/_modal_login') ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-12">
                <?php if ($model->userIsSubscribed): ?>
                    <button class="btn btn-block btn-warning text-uppercase btn-flat"
                            disabled="disabled" type="button">
                        Вы ожидаете поступления
                    </button>
                <?php else: ?>
                    <button id="send_subscription" data-id="<?= $model->productID ?>"
                            class="btn btn-block btn-warning text-uppercase btn-flat" type="submit">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        Сообщить о поступлении
                    </button>
                <?php endif; ?>

            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; ?>

<?php endif; ?>


<div class="wrapper row flex product_actions">
    <div class="col-md-6 col-sm-12">
        <div class="price-block">
            <?= $this->render('//shop/category/product_views/parts/__product_price_block', ['model' => $model]); ?>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <?php if ($model->countInCart > 0): ?>
            <div class="text-center text-danger">В корзине: <?= $model->countInCart ?> шт.</div>
        <?php endif; ?>
        <?php if ($model->canAdd == 1): ?>
            <?php
            $modelf = new \frontend\models\AddToCartForm;
            $form = \yii\widgets\ActiveForm::begin([
                'id' => 'add-to-cart-form',
                'action' => ['/shop/add-to-cart'],
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
                'options' => ['data-name' => $model->name_ru]
            ]) ?>
            <?= \yii\helpers\Html::activeHiddenInput($modelf, 'count', ['value' => '1']); ?>
            <?= \yii\helpers\Html::activeHiddenInput($modelf, 'product', ['value' => $model->productID]) ?>
            <button class="btn btn-primary btn-flat btn-block text-uppercase buybtn" type="submit"><i
                        class="fa fa-shopping-cart"
                        aria-hidden="true"></i> КУПИТЬ
            </button>
            <button class="btn btn-primary btn-flat btn-block buybtn" style="display: none"
                    disabled="disabled"
                    type="button"><i class="fa fa-spinner fa-spin fa-fw"></i></button>


            <?php \yii\widgets\ActiveForm::end(); ?>
        <?php else: ?>
            <button class="btn btn-block btn-default text-uppercase disabled btn-flat" type="submit"><i
                        class="fa fa-times"
                        aria-hidden="true"></i>
                <?= $model->canAdd ?>
            </button>

        <?php endif; ?>
        <?=$this->render("//shop/category/product_views/parts/_brand_button", ['model'=>$model])?>
    </div>

</div>