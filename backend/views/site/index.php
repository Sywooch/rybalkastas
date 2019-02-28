<?php

/* @var $this yii\web\View */
use dosamigos\chartjs\ChartJs;
$this->title = 'Статистика';

backend\assets\MorrisAsset::register($this);
?>

<div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Статистика по заказам</h3><br>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php
                $labels = [];
                $sets = [];

                foreach($orderStats as $k=>$s){
                    $labels[] = Yii::$app->formatter->asDate($k, 'long');
                    foreach ($s as $ks=>$ksv){
                        $sets[$ks][] = $ksv;
                    }
                }

            ?>


            <?= ChartJs::widget([
                'type' => 'line',
                'options'=>[
                    'height'=>'400px',

                ],

                'data' => [

                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Не обработанные",
                            'backgroundColor' => "rgba(196, 196, 196,0.4)",
                            'borderColor' => "rgba(196, 196, 196,1)",

                            'data' => $sets['new'],
                            'fill'=>true,
                        ],
                        [
                            'label' => "Отмененные",
                            'backgroundColor' => "rgba(178,34,34,0.6)",
                            'borderColor' => "rgba(178,34,34,1)",

                            'data' => $sets['cancelled']
                        ],
                        [
                            'label' => "Закрытые",
                            'backgroundColor' => "rgba(0, 170, 255, 0.5)",
                            'borderColor' => "rgb(0, 170, 255)",

                            'data' => $sets['done']
                        ],
                        [
                            'label' => "Все заказы",
                            'backgroundColor' => "rgba(255, 161, 69, 1)",
                            'borderColor' => "#ffa145",

                            'data' => $sets['all'],
                            'fill'=>true,
                        ],



                    ]
                ],
                'clientOptions' => [
                    'responsive'=>true,
                    'showTooltips'=>true,
                    'tooltips'=>[
                        'enabled'=>true,
                        //'mode'=>'x-axis',
                    ],
                    'maintainAspectRatio'=>false
                ]
            ]);
            ?>
        </div><!-- /.box-body -->
        <div class="box-footer text-center">
            <?php for ($i=0; $i<=12; $i++):?>
                <a href="<?=\yii\helpers\Url::current(['ordersMonth'=>date('Y-m', strtotime("-$i month"))])?>" class="btn <?=($i==0)?"btn-warning":"btn-primary"?>"><?=Yii::$app->formatter->asDate(strtotime("-$i month"), 'MMM Y')?></a>
            <?php endfor;?>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Статистика по посещаемости</h3><br>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php
            $labels = [];
            $sets = [];

            foreach($userStats as $k=>$s){
                $labels[] = Yii::$app->formatter->asDate($k, 'long');
                $sets[] = $s;
            }

            ?>

            <?= ChartJs::widget([
                'type' => 'line',
                'options'=>[
                    'height'=>'400px',

                ],

                'data' => [

                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Количество уникальных посетителей",
                            'backgroundColor' => "rgba(245, 97, 255, 0.7)",
                            'borderColor' => "rgba(245, 97, 255, 1)",

                            'data' => $sets,
                            'fill'=>true,
                        ]
                    ]
                ],
                'clientOptions' => [
                    'responsive'=>true,
                    'showTooltips'=>true,
                    'tooltips'=>[
                        'enabled'=>true,
                        //'mode'=>'x-axis',
                    ],
                    'maintainAspectRatio'=>false
                ]
            ]);
            ?>

        </div><!-- /.box-body -->
        <div class="box-footer text-center">
            <?php for ($i=0; $i<=12; $i++):?>
                <a href="<?=\yii\helpers\Url::current(['usersMonth'=>date('m-Y', strtotime("-$i month"))])?>" class="btn <?=($i==0)?"btn-warning":"btn-primary"?>"><?=\Yii::t('app', '{0, date, LLLL Y}', strtotime("-$i month")); ?></a>
            <?php endfor;?>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Топ 10 товаров по просмотрам</h3><br>
        </div><!-- /.box-header -->
        <div class="box-body">

                <?php
                $labels = [];
                $sums = [];
                foreach($topProducts as $tp){
                    $labels[] = $tp['model']->name_ru;
                    $sums[] = $tp['sum'];
                }
                $colors = ['#FF0040','#FF1400','#FF4600','#FF7800','#FFa000','#FFdc00','#fdff00','#3eff00','#00ff83','#00d4ff'];

                ?>

            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => '400px',
                ],
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Топ 10 просматриваемых товаров",
                            'data' => $sums,
                            'backgroundColor'=>$colors,
                        ]
                    ]
                ],
                'clientOptions' => [
                    'responsive'=>true,
                    'showTooltips'=>true,
                    'tooltips'=>[
                        'enabled'=>true,
                        //'mode'=>'x-axis',
                    ],
                    'maintainAspectRatio'=>false
                ]
            ]);
            ?>
        </div><!-- /.box-body -->
    </div>
</div>

<div class="col-md-6">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Топ 10 товаров по продажам (от 1000 руб.)</h3><br>
        </div><!-- /.box-header -->
        <div class="box-body">

            <?php
            $labels = [];
            $sums = [];
            foreach($topSelling as $tp){
                $labels[] = $tp['name'];
                $sums[] = $tp['num'];
            }
            $colors = ['#FF0040','#FF1400','#FF4600','#FF7800','#FFa000','#FFdc00','#fdff00','#3eff00','#00ff83','#00d4ff'];

            ?>

            <?= ChartJs::widget([
                'type' => 'pie',
                'options' => [
                    'height' => '400px',
                ],
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Топ 10 просматриваемых товаров",
                            'data' => $sums,
                            'backgroundColor'=>$colors,
                        ]
                    ]
                ],
                'clientOptions' => [
                    'responsive'=>true,
                    'showTooltips'=>true,
                    'tooltips'=>[
                        'enabled'=>true,
                        //'mode'=>'x-axis',
                    ],
                    'maintainAspectRatio'=>false
                ]
            ]);
            ?>
        </div><!-- /.box-body -->
    </div>
</div>

