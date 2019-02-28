<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Отложенные товары');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div id="laterProductsContainer" class="panel-body">
                <table class="table table-bordered table-striped table-hover later-table">
                    <tr>
                        <th></th>
                        <th>Наименование</th>
                        <th>Наличие</th>
                        <th>Цена</th>
                        <th></th>
                    </tr>
                    <?php foreach($model as $m):?>
                        <?php if(empty($m->product)){
                            continue;
                        }?>
                        <tr>
                            <td class="product_picture">
                                <?php if (isset($m->product->pictures[0])): ?>
                                    <?= Html::img(Yii::$app->imageman->load('/products_pictures/' . $m->product->pictures[0]->largest, '100x100', Yii::$app->settings->get('image', 'productBig'), false, 'products'), ['alt' => $m->product->name_ru]) ?>
                                <?php endif; ?>
                            </td>
                            <td class="product_name">
                                <a href="<?=\yii\helpers\Url::to(['/shop/category', 'id'=>$m->product->categoryID, 'product'=>($m->product instanceof \common\models\SCProducts?$m->product->productID:null)])?>"><?=$m->product->name_ru?></a>
                            </td>
                            <td class="stock">
                                <?php if($m->product->canAdd == 1):?>
                                    В&nbsp;наличии
                                <?php else:?>
                                    <?=$m->product->canAdd?>
                                <?php endif;?>
                            </td>
                            <td class="prices">
                                <div class="new <?php if($m->product->Price > $m->product->actualPrice):?>through<?php endif;?>"><?= $m->product->normalPrice ?>&nbsp;руб</div>
                                <?php if($m->product->Price > $m->product->actualPrice):?>
                                    <div class="actual">
                                        <span class="price"><?= $m->product->normalActualPrice ?>&nbsp;руб</span>
                                    </div>
                                <?php endif;?>
                            </td>
                            <td class="actions">
                                <?php if ($m->product->canAdd == 1): ?>
                                    <?php
                                    $modelf = new \frontend\models\AddToCartForm;
                                    $form = ActiveForm::begin([
                                        'options'=>[
                                            'class' => 'add-to-cart-form',
                                        ],
                                        'action' => ['/shop/add-to-cart'],
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => false,
                                        'validateOnBlur' => false,
                                        'validateOnType' => false,
                                        'validateOnChange' => false,
                                    ]) ?>
                                            <input type="hidden" name="removeFromLater" value="1"/>
                                            <?= $form->field($modelf, 'count')->hiddenInput(['value'=>1])->label(false)->hint(false) ?>
                                            <?= \yii\helpers\Html::activeHiddenInput($modelf, 'product', ['value' => $m->product->productID]) ?>
                            <button class="btn btn-sm btn-primary btn-flat text-uppercase buybtn" type="submit"><i class="fa fa-shopping-cart"
                                                                                                            aria-hidden="true"></i> КУПИТЬ</button>
                            <button class="btn btn-sm btn-primary btn-flat buybtn" style="display: none" disabled="disabled"
                                    type="button"><i class="fa fa-spinner fa-spin fa-fw"></i></button>
                                    <?php ActiveForm::end(); ?>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-default text-uppercase disabled btn-flat" type="submit">
                                        <?=$m->product->canAdd?>
                                    </button>
                                <?php endif; ?>
                                <a data-toggle="tooltip" data-placement="top" title="Удалить" class="btn btn-sm btn-danger text-uppercase btn-flat deleteLater" href="<?=\yii\helpers\Url::to(['/shop/remove-later', 'productID'=>$m->productID])?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="product_modal_container"></div>
