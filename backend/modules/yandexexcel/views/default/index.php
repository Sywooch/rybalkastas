<?php
use dosamigos\chartjs\ChartJs;
use common\models\SCOrders;
backend\assets\MorrisAsset::register($this);

?>

<?php $this->title = "Yandex Market"?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Дэшборд <b>Yandex Market</b></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Заказы за последние 2 недели</strong>
                        </p>
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
                    </div>
                    <?php

                    $countAll = SCOrders::find()->where(['between', 'order_time', $begin, $end])->andWhere(['source_ref'=>'ymrkt'])->andWhere([])->count();
                    $countSuccess = SCOrders::find()->where(['between', 'order_time', $begin, $end])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>5])->count();
                    $countCancel = SCOrders::find()->where(['between', 'order_time', $begin, $end])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>1])->count();
                    $countNA = SCOrders::find()->where(['between', 'order_time', $begin, $end])->andWhere(['source_ref'=>'ymrkt'])->andWhere(['statusID'=>3])->count();


                    ?>
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Показатели</strong>
                        </p>

                        <div class="progress-group">
                            <span class="progress-text">Всего заказов</span>
                            <span class="progress-number"><b><?=$countAll?></b></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            <span class="progress-text">Закрытые</span>
                            <span class="progress-number"><b><?=$countSuccess?></b>/<?=$countAll?></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-aqua" style="width: <?=round(100/$countAll*$countSuccess)?>%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Отмененные</span>
                            <span class="progress-number"><b><?=$countCancel?></b>/<?=$countAll?></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-red" style="width:  <?=round(100/$countAll*$countCancel)?>%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Не обработанные</span>
                            <span class="progress-number"><b><?=$countNA?></b>/<?=$countAll?></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-green" style="width: <?=round(100/$countAll*$countNA)?>%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                        <!-- /.progress-group -->

                        <div>
                            <a href="<?=\yii\helpers\Url::to(['download'])?>" class="btn btn-primary btn-block">Выгрузить таблицу текущей выгрузки</a>
                            <br/>
                            Загрузить новую таблицу выгрузки
                            <input type="file" id="newXls" class="btn btn-warning btn-block" />
                        </div>
                    </div>
                    <div class="clearfix"></div>


                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?=\common\models\SCProducts::find()->where(['upload2market'=>1])->count()?></h5>
                            <span class="description-text">Количество товаров выгружено</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-xs-12">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?=\common\models\SCProducts::find()->where(['upload2market'=>1])->andWhere(['>', 'in_stock', 0])->count()?></h5>
                            <span class="description-text">Количество товаров в наличии</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 col-xs-12">
                        <div class="description-block border-right">
                            <?php
                            $keywords = array (
                                'скидка',
                                'распродажа',
                                'дешевый',
                                'подарок',
                                'бесплатно',
                                'акция',
                                'специальная цена',
                                'новинка',
                                'new',
                                'аналог',
                                'заказ',
                            );
                            ?>
                            <h5 class="description-header"><?=\common\models\SCProducts::find()->where(['upload2market'=>1])->andWhere(['>', 'in_stock', 0])->andWhere(['>', 'Price', 0])->andWhere(['not in', 'name_ru', $keywords])->andWhere(['not in', 'description_ru', $keywords])->count()?></h5>
                            <span class="description-text">Количество товаров в маркете</span>
                        </div>
                        <!-- /.description-block -->
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<?php
$url = \yii\helpers\Url::to(['upload']);
$js = <<<JS
$('#newXls').change(function(){
    formData = new FormData();
    formData.append('newImageUpload', $(this).prop('files')[0]);
    
    $.ajax({
      url: '$url',
      type: 'POST',
      processData: false, // important
      contentType: false, // important
      //dataType : 'json',
      data: formData,
      success: function(data){
          
          alert(data.msg);
      },
    }); 
});
JS;
$this->registerJs($js);
?>