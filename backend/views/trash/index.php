<?php
$this->title = "Корзина";

?>

<div class="col-md-12">
    <div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Удаленные элементы</h3>
                <div class="box-tools pull-right">
                    <?php \yii\widgets\ActiveForm::begin();?>
                    <a href="<?=\yii\helpers\Url::to(['restore-everything'])?>" class="btn btn-success"><i class="fa fa-play"></i> Восстановить все</a>
                    <a href="<?=\yii\helpers\Url::to(['remove-everything'])?>" class="btn btn-danger"><i class="fa fa-times"></i> Удалить все</a>
                    <?php \yii\widgets\ActiveForm::end();?>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-striped dataTable">
                    <tr>
                        <th>Объект</th>
                        <th>Имя</th>
                        <th>Ответственный</th>
                        <th>Когда</th>
                        <th>Действие</th>
                    </tr>
                    <?php foreach($models as $model):?>
                        <tr>
                            <td><b><?=$model->type?></b></td>
                            <td><?=$model->itemName?></td>
                            <td><?=$model->user->showName?></td>
                            <td><?=Yii::$app->formatter->asRelativeTime($model->created_at)?></td>
                            <td>
                                <a href="<?=\yii\helpers\Url::to(['restore', 'id'=>$model->id])?>" class="btn btn-xs btn-success">Восстановить</a>
                                <a href="<?=\yii\helpers\Url::to(['remove', 'id'=>$model->id])?>" class="btn btn-xs btn-danger">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <?=\yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                ]);?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

