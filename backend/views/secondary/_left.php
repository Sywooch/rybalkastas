<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 24.03.2016
 * Time: 12:47
 */
$m = \common\models\SCSecondaryPages::find()->all();
?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Все вторички</h3>
    </div>
    <div class="box-body">
        <a href="<?=\yii\helpers\Url::to(["/secondary/create"])?>" type="button" class="btn btn-success btn-block">Создать</a>
        <?php foreach($m as $mo):?>
            <a href="<?=\yii\helpers\Url::to(["/secondary/item", 'id'=>$mo->id])?>" type="button" class="btn btn-default btn-block <?php if(isset($id) && $id == $mo->id) echo "disabled"; ?>"><?=$mo->name;?></a>
        <?php endforeach;?>
    </div>
</div>
