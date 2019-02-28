<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 30.11.2015
 * Time: 15:18
 */

$this->title = "Стили CSS";

?>

<div class="col-md-8 col-md-offset-2">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-cogs"></i>
            <h3 class="box-title">Список <small>всех активных стилей CSS</small></h3>
        </div><!-- /.box-header -->
        <div class="box-body" id="actions">
            <?php foreach($model as $m):?>
                <a href="<?=\yii\helpers\Url::to(["/content/css/edit", 'id'=>$m->id]);?>" class="btn btn-app">
                    <i class="fa"><?=$m->name;?></i> <?=$m->description;?>
                </a>
            <?php endforeach;?>
        </div>
    </div>
</div>


