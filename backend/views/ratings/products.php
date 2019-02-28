<?php
/* @var $this yii\web\View */
$this->title = "Отзывы";
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php if($showhidden == 0):?>
    <a href="<?=\yii\helpers\Url::toRoute(['ratings/products', 'showhidden'=>1])?>" class="btn btn-primary btn-lg btn-block">Показать скрытые</a>
<?php else:?>
    <a href="<?=\yii\helpers\Url::toRoute(['ratings/products', 'showhidden'=>0])?>" class="btn btn-primary btn-lg btn-block">Спрятать скрытые</a>
<?php endif;?>

<?php foreach($model as $m):?>
    <?php
    if(number_format($m->rating,1) >= 4.5){
        $class = 'success';
    } elseif (number_format($m->rating,1) >= 3.5){
        $class = 'warning';
    } else {
        $class = 'danger';
    }
    ?>
    <div class="panel panel-<?=$class;?>">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php if(!empty($m->user)):?><a href="<?=\yii\helpers\Url::toRoute(['/orders/user', 'id'=>$m->user_id]);?>" target="_blank"><?=$m->user->first_name?> <?=$m->user->last_name?></a><?php else:?>[УДАЛЕН]<?php endif;?> | <b><?=$m->dateform?></b>
                | на товар <a href="http://rybalkashop.ru/index.php?categoryID=<?=$m->categoryID;?>"><?=!empty($m->category)?$m->category->name_ru:"[УДАЛЕН]";?></a>
                <?php if($m->approved == 0):?>
                    <span class="label label-danger">Не подтвержден</span>
                <?php else:?>
                    <span class="label label-success">Подтвержден</span>
                <?php endif;?>

                <?php if($m->hidden == 1):?>
                    <span class="label label-primary">Скрыт</span>
                <?php endif;?>

            </h3>
        </div>
        <div class="panel-body text">
            <?=$m->comment_text;?>
        </div>
        <div class="panel-footer" style="color: #D59D00;font-size: 22px;"><?=$m->stars;?> |
            <?php if(empty($m->response_text)):?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-<?=$m->rating_id;?>" data-id="<?=$m->rating_id;?>">
                    Написать ответ
                </button>
            <?php else:?>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-<?=$m->rating_id;?>" data-id="<?=$m->rating_id;?>">
                    Изменить ответ
                </button>
            <?php endif;?>

            <div class="pull-right">
                <?php
                $form = ActiveForm::begin([
                    'options' => ['class' => 'form-semihidden'],
                    'fieldConfig' => [
                        'template' => "{input}",
                    ],
                ]) ?>
                <?= $form->field($m, 'rating_id')->hiddenInput()->label(''); ?>
                <?php if($m->hidden == 1):?>
                    <?= $form->field($m, 'hidden')->hiddenInput(['value'=>'0'])->label(''); ?>
                    <?= Html::submitButton('Показать отзыв', ['class' => 'btn btn-primary']) ?>
                <?php else:?>
                    <?= $form->field($m, 'hidden')->hiddenInput(['value'=>'1'])->label(''); ?>
                    <?= Html::submitButton('Скрыть отзыв', ['class' => 'btn btn-primary']) ?>
                <?php endif;?>
                <?php ActiveForm::end() ?>
            </div>

            <div class="pull-right">
                <?php
                $form = ActiveForm::begin([
                    'options' => ['class' => 'form-semihidden'],
                    'fieldConfig' => [
                        'template' => "{input}",
                    ],
                ]) ?>
                <?= $form->field($m, 'rating_id')->hiddenInput()->label(''); ?>
                <?php if($m->approved == 0):?>
                    <?= $form->field($m, 'approved')->hiddenInput(['value'=>'1'])->label(''); ?>
                    <?= Html::submitButton('Подтвердить отзыв', ['class' => 'btn btn-success']) ?>
                <?php else:?>
                    <?= $form->field($m, 'approved')->hiddenInput(['value'=>'0'])->label(''); ?>
                    <?= Html::submitButton('Отменить подтверждение отзыва', ['class' => 'btn btn-danger']) ?>
                <?php endif;?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-<?=$m->rating_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
        ]) ?>
        ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Ответить</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="well response">
                            <?=$m->comment_text;?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($m, 'rating_id')->hiddenInput()->label(''); ?>
                            <?= $form->field($m, 'response_text')->textarea(); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>

<?php endforeach;?>



<?php
echo LinkPager::widget([

    'pagination' => $pages,

]);
?>

<style>
    .form-semihidden .form-group{
        display: none;
    }
</style>
