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

            <h3 class="box-title">Вопросы экспертам</h3>
            <a href="<?=Url::to(['expert-questions/create'])?>" type="button" class="btn btn-success pull-right">Создать страницу эксперта</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php foreach($pages as $page):?>
            <div class="col-md-4">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-yellow">
                            <div class="expert_av" style="display:inline-block; vertical-align:middle;width: 65px;   height: 65px; float: left;   background: url(/img/experts/<?=$page->picture?>) no-repeat;border-radius: 150px;background-size: 212px 136px;   -webkit-border-radius: 150px;   -moz-border-radius: 150px;   background-position: top left 50%;"></div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username"><?=$page->expert_name?> <?=$page->expert_last_name?></h3>
                        <h5 class="widget-user-desc"><?=$page->shop?></h5>
                        <?php if(empty($page->connection)):?>
                            <a href="<?=Url::to(['expert-questions/connect', 'id'=>$page->expert_id])?>"><span class="badge bg-red">Связать учетные записи</span></a>
                        <?php else:?>
                            <span class="badge bg-green">Учетная запись привязана!</span>
                        <?php endif;?>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="#">Вопросов эксперту <span class="pull-right badge bg-blue"><?=count($page->questions)?></span></a></li>
                            <li><a href="<?=Url::to(['edit', 'id'=>$page->expert_id])?>">Редактировать</a></li>
                            <li style="cursor: pointer">
                                <?php
                                \yii\bootstrap\Modal::begin([
                                    'header' => '<h2>Информация о пользователе '.$page->expert_name.' '.$page->expert_last_name.'</h2>',
                                    'toggleButton' => ['label' => 'Информация <span class="pull-right badge bg-red">!</span>', 'tag'=>'a'],
                                ]);
                                ?>
                                
                                <div class="panel">
                                    Логин на сайте: <?=$page->scAccount->Login?><br/>
                                    Пароль на сайте: <?=base64_decode($page->scAccount->cust_password)?>
                                </div>
                                
                                <?php \yii\bootstrap\Modal::end();?>
                            </li>
                            <!--<li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                            <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>-->
                        </ul>
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
            <?php endforeach;?>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>



