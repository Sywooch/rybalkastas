<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 31.12.2015
 * Time: 13:12
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\components\ArrayMapHelper;

$this->title = 'Массовая отвечалка на вопросы';
?>

<div class="col-md-12">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <?php foreach($model as $m):?>
            <?php if($m->hasAnswer)continue;?>
            <div class="box box-widget q-box" id="form-<?=$m->id;?>">
                <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="/images/user.jpg" alt="User Image">
                        <?php
                        if(empty($m->user)){
                            $m->delete();
                            continue;
                        }
                        if(empty($m->operator)){
                            $m->delete();
                            continue;
                        }
                        ?>
                        <span class="username">
                            <?=$m->user->first_name?>
                            <?=$m->user->last_name?> менеджеру
                            <?=$m->operator->expert_name?>
                            <?=$m->operator->expert_last_name?>
                        </span>
                        <span class="description"><?=$m->humanDate?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <?php echo \yii\helpers\Html::a('<i class="fa fa-times"></i>', ['delete-post', 'id' => $m->id], [
                            'class' => 'btn btn-box-tool',
                            'data' => [
                                'confirm' => 'Удалить сообщение?'
                            ],
                        ]) ?>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p><?=$m->content?></p>
                </div>
                <!-- /.box-footer -->
                <div class="box-footer">
                    <form id="q-<?=$m->id?>" class="q-form" action="<?=Url::to(['/interaction/expert-questions/put-answer'])?>" method="post">
                        <img class="img-responsive img-circle img-sm" src="/img/experts/<?=$m->operator->picture?>" alt="Alt Text">
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">
                            <input type="hidden" name="id" value="<?=$m->id;?>">
                            <input type="text" class="form-control input-sm" name="answer" placeholder="Написать ответ">
                        </div>
                        <button class="btn btn-block btn-flat bg-olive">Отправить!</button>
                    </form>
                </div>
                <!-- /.box-footer -->
            </div>

        <?php endforeach;?>
</div>

<?php $js = <<< JS
    var options = {
        success: function(responseText, statusText, xhr, form)
            {
                $('#form-'+responseText).hide(200);
            }
    };

    $('.q-form').ajaxForm(options);
JS;
$this->registerJs($js);

