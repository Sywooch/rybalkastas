<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$model->name?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?=\yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_task_inlist',
        ]);?>
    </div>

</div>