<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.12.2015
 * Time: 13:12
 */
use yii\helpers\Url;

?>


<div class="col-md-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-warning"></i>

            <h3 class="box-title">Опросы</h3>
            <a href="<?=Url::to(['quiz/create'])?>" type="button" class="btn btn-success pull-right">Создать опрос</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

    <?php foreach($model as $m):?>

        <a style="display: block" href="<?=Url::to(['quiz/edit', 'id'=>$m->id])?>">
            <div class="callout callout-info">
                <h4  class="pull-left"><?=$m->name;?></h4>
                <p class="pull-left">

                </p>
                <div class="pull-right">
                    <div>Статус: <?=($m->active==1?"Активен":"Закрыт")?></div>
                    <div>Видимость: <?=($m->show==1?"Показан":"Скрыт")?></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </a>

    <?php endforeach;?>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>



