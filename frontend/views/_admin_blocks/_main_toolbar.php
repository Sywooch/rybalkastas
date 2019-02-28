<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 13.11.2017
 * Time: 8:37
 */
if (\Yii::$app->user->can('superFasdield')):?>
    <?php

    $begin = date('Y-m-d 00:00:00');
    $end = date('Y-m-d 23:59:59');

    $sum = \common\models\SCOrders::find()->where(['between', 'order_time', $begin, $end])->sum('order_amount');
    $count = \common\models\SCOrders::find()->where(['between', 'order_time', $begin, $end])->count();

    ?>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-default navbar-admin hidden-sm hidden-xs">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a>Активные сессии: <b
                                        class="text-red"><?= count(\Yii::$app->session->getOnlineUsers()) ?></b></a>
                        </li>
                        <li><a>Заказы: <b class="text-red"><?= $count ?></b> / <b class="text-red"><?= $sum ?> <i
                                            class="fa fa-ruble"></i></b> </a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

<?php endif; ?>
