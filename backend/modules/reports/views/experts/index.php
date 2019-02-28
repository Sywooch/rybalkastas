<?php
$this->title = 'Графики взятых заказов менеджеров';
?>

<div id="main">
    <div class="col-md-12">
        <select class="form-control" v-model="period">
            <option v-for="period in periods" :value="period.key">{{period.label}}</option>
        </select>
    </div>
    <?php foreach($shops as $shop):?>
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$shop->name?></h3>
                <br>
            </div><!-- /.box-header -->
            <div class="box-body">
                <canvas id="expertsChart<?=$shop->shopID?>"></canvas>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<script>
    var shops = [];
    var charts = {};
    <?php foreach($shops as $shop):?>
        shops.push(<?=\yii\helpers\Json::encode($shop)?>);
        charts[<?=$shop->shopID?>] = null;
    <?php endforeach;?>
    window.shops = shops;
</script>