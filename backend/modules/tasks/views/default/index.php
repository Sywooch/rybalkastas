<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Открытые задачи</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Пакет</th>
                <th>Количество задач</th>
                <th>Прогресс</th>
                <th style="width: 40px">%</th>
            </tr>
            <?php foreach ($packs as $p):?>
                <?php
                $count = \common\models\stack\StackTasks::find()->where(['pack_id'=>$p->id])->count();
                $countApproved = \common\models\stack\StackTasks::find()->where(['pack_id'=>$p->id])->andWhere(['status'=>\common\models\stack\StackTasks::STATUS_APPROVED])->count();
                $percent = 100/$count*$countApproved;
                ?>
            <tr>
                <td><?=$p->id?></td>
                <td><a href="<?=\yii\helpers\Url::to(['pack', 'id'=>$p->id])?>"><?=$p->name?></a></td>
                <td><?=\common\models\stack\StackTasks::find()->where(['pack_id'=>$p->id])->count()?></td>
                <td>
                    <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar progress-bar-danger" style="width: <?=$percent?>%"></div>
                    </div>
                </td>
                <td><span class="badge bg-red"><?=$percent?>%</span></td>
            </tr>
            <?php endforeach;?>
            </tbody></table>
    </div>

</div>