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
use yii\widgets\Menu;

/**
 * @var dektrium\user\models\User $user
 */

$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Html::img($user->profile->getThumbUrl(30, 30), ['style'=>'width:25px']) ?>
            <?= empty($user->profile->name)?$user->username:$user->profile->name  ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => [
                ['label' => Yii::t('user', 'Покупатель'), 'url' => ['/user/settings/customer']],
                ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
                ['label' => Yii::t('user', 'Account'), 'url' => ['/user/settings/account']],
                ['label' => Yii::t('user', 'Заказы'), 'url' => ['/user/settings/orders']],
                ['label' => Yii::t('user', 'Отложенные товары'), 'url' => ['/user/settings/laterproducts']],
                ['label' => Yii::t('user', 'Ожидаемые товары').'<span class="badge badge-pill badge-danger">'.$user->customer->requestedCount.'</span>', 'url' => ['/user/settings/requestedproducts']],
                [
                    'label' => Yii::t('user', 'Networks'),
                    'url' => ['/user/settings/networks'],
                    'visible' => $networksVisible
                ],
            ],
            'encodeLabels'=>false,
        ]) ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Клуб Rybalkashop.ru
    </div>
    <div class="panel-body">
        <?php if(!empty($user->customer) && !empty($user->customer->card)):?>
            Привязана карта<br/>
            №<b class="text-red"><?=$user->customer->card->number?></b>
        <?php else:?>
            Карта не привязана
        <?php endif;?>
    </div>
</div>
