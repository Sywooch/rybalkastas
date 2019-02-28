<?php
$this->title = "Ограниченная статистика";
$begin = date('Y-m-d 00:00:00');
$end = date('Y-m-d 23:59:59');

$sum = \common\models\SCOrders::find()->where(['between', 'order_time', $begin, $end])->sum('order_amount');
$count = \common\models\SCOrders::find()->where(['between', 'order_time', $begin, $end])->count();
$model = \common\models\mongo\IpsByDate::find()->where(['date' => date('d-m-Y')])->one();
$countUsers = count($model['ips']);

$currentTime = strtotime(date('d-m-Y'));

?>
<div class="alert alert-danger" role="alert">
    Пришлось отключить динамику на время проведения черной пятницы. Данные по сегодняшним заказам будут прописаны прямо
    здесь.
</div>

<div class="container">
    <div class="row bs-wizard" style="border-bottom:0;">
        <?php
        $daytime = strtotime(date('23-11-2017'));
        $day = '2017-11-23';
        $day2 = '23-11-2017';
        $dayBegin = $day.' 00:00:00';
        $dayEnd = $day.' 23:59:59';

        if ($currentTime == $daytime) {
            $step = 'active';
        } elseif ($currentTime > $daytime) {
            $step = 'complete';
        } else {
            $step = 'disabled';
        }

        $sum = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->sum('order_amount');
        $count = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->count();
        $model = \common\models\mongo\IpsByDate::find()->where(['date' => $day2])->one();
        $countUsers = count($model['ips']);
        ?>
        <div class="col-xs-3 bs-wizard-step <?=$step?>">

            <div class="text-center bs-wizard-stepnum">23.11</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
            <div class="bs-wizard-info text-center">
                <p>Общее число заказов: <b class=""><?= $count ?></b></p>
                <p>Общая сумма заказов: <b class=""><?= number_format($sum, 2) ?></b> руб.</p>
                <p>Число уникальных посетителей: <b class=""><?= $countUsers ?></b></p>
            </div>
        </div>

        <?php
        $daytime = strtotime(date('24-11-2017'));
        $day = '2017-11-24';
        $day2 = '24-11-2017';
        $dayBegin = $day.' 00:00:00';
        $dayEnd = $day.' 23:59:59';

        if ($currentTime == $daytime) {
            $step = 'active';
        } elseif ($currentTime > $daytime) {
            $step = 'complete';
        } else {
            $step = 'disabled';
        }

        $sum = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->sum('order_amount');
        $count = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->count();
        $model = \common\models\mongo\IpsByDate::find()->where(['date' => $day2])->one();
        $countUsers = count($model['ips']);
        ?>
        <div class="col-xs-3 bs-wizard-step  <?=$step?>"><!-- complete -->
            <div class="text-center bs-wizard-stepnum">24.11</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
            <div class="bs-wizard-info text-center">
                <p>Общее число заказов: <b class=""><?= $count ?></b></p>
                <p>Общая сумма заказов: <b class=""><?= number_format($sum, 2) ?></b> руб.</p>
                <p>Число уникальных посетителей: <b class=""><?= $countUsers ?></b></p>
            </div>
        </div>

        <?php
        $daytime = strtotime(date('25-11-2017'));
        $day = '2017-11-25';
        $day2 = '25-11-2017';
        $dayBegin = $day.' 00:00:00';
        $dayEnd = $day.' 23:59:59';

        if ($currentTime == $daytime) {
            $step = 'active';
        } elseif ($currentTime > $daytime) {
            $step = 'complete';
        } else {
            $step = 'disabled';
        }

        $sum = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->sum('order_amount');
        $count = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->count();
        $model = \common\models\mongo\IpsByDate::find()->where(['date' => $day2])->one();
        $countUsers = count($model['ips']);
        ?>
        <div class="col-xs-3 bs-wizard-step  <?=$step?>"><!-- complete -->
            <div class="text-center bs-wizard-stepnum">25.11</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
            <div class="bs-wizard-info text-center">
                <p>Общее число заказов: <b class=""><?= $count ?></b></p>
                <p>Общая сумма заказов: <b class=""><?= number_format($sum, 2) ?></b> руб.</p>
                <p>Число уникальных посетителей: <b class=""><?= $countUsers ?></b></p>
            </div>
        </div>

        <?php
        $daytime = strtotime(date('26-11-2017'));
        $day = '2017-11-26';
        $day2 = '26-11-2017';
        $dayBegin = $day.' 00:00:00';
        $dayEnd = $day.' 23:59:59';

        if ($currentTime == $daytime) {
            $step = 'active';
        } elseif ($currentTime > $daytime) {
            $step = 'complete';
        } else {
            $step = 'disabled';
        }

        $sum = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->sum('order_amount');
        $count = \common\models\SCOrders::find()->where(['between', 'order_time', $dayBegin, $dayEnd])->count();
        $model = \common\models\mongo\IpsByDate::find()->where(['date' => $day2])->one();
        $countUsers = count($model['ips']);
        ?>
        <div class="col-xs-3 bs-wizard-step  <?=$step?>"><!-- active -->
            <div class="text-center bs-wizard-stepnum">26.11</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
            <div class="bs-wizard-info text-center">
                <p>Общее число заказов: <b class=""><?= $count ?></b></p>
                <p>Общая сумма заказов: <b class=""><?= number_format($sum, 2) ?></b> руб.</p>
                <p>Число уникальных посетителей: <b class=""><?= $countUsers ?></b></p>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning" role="alert">
    <?php
    $sum = \common\models\SCOrders::find()->where(['between', 'order_time', '2017-11-23 00:00:00', '2017-11-26 23:59:59'])->sum('order_amount');
    $count = \common\models\SCOrders::find()->where(['between', 'order_time', '2017-11-23 00:00:00', '2017-11-26 23:59:59'])->count();
    $model = \common\models\mongo\IpsByDate::find()->where(['in', 'date', ['23-11-2017','24-11-2017','25-11-2017','26-11-2017']])->all();
    $countUsers = 0;
    foreach($model as $m){
        $countUsers += count($m['ips']);
    }

    ?>
    <h1>Показатели на черную пятницу:</h1>
    <p>Общее число заказов: <b class=""><?= $count ?></b></p>
    <p>Общая сумма заказов: <b class=""><?= number_format($sum, 2) ?></b> руб.</p>
    <p>Число уникальных посетителей: <b class=""><?= $countUsers ?></b></p>
    <br/>
    <br/>
</div>

<hr/>
<hr/>
<h1 class="text-center">Черная пятница 2016:</h1>
<hr/>
<hr/>

    <?=$this->render('_prev_friday')?>


