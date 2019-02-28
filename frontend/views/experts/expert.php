<?php
/**
 * Created by PhpStorm.
 * User: TurningTide
 * Date: 10.04.2017
 * Time: 9:39
 */

$this->title = $model->expert_name . ' ' . $model->expert_last_name;
$this->params['breadcrumbs'][] = ['url' => \yii\helpers\Url::to(['/experts/index']), 'label' => "Консультации экспертов"];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="jumbotron">
    <div class="col-md-3">
        <img src="<?= Yii::$app->imageman->load('/experts/' . $model->picture, '250x250', 100, false, 'expert_circles', true) ?>"
             class="center-block">
    </div>
    <div class="col-md-9">
        <h1><?= $this->title ?></h1>
        <p><?= $model->mini_description ?></p>
    </div>
    <div class="clearfix"></div>
</div>
<?php if(!Yii::$app->user->isGuest):?>
    <?php $newPost = new \frontend\models\ExpertQuestion();?>
    <?php $form = \yii\widgets\ActiveForm::begin();?>
        <?= $form->field($newPost, 'message')->textarea(['rows'=>5]);?>
        <button type="submit" class="btn btn-success pull-right">Отправить</button>
    <div class="clearfix"></div>
    <br/>
    <?php \yii\widgets\ActiveForm::end();?>
<?php else:?>
    <div class="callout callout-warning">

        <p>Для того, чтобы задать вопрос эксперту, необходимо авторизоваться на сайте.</p>
    </div>
<?php endif;?>
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Вопросы и ответы</h3>
        <!-- /.box-tools -->
    </div>

    <!-- /.box-header -->
    <div class="box-body comment-box" id="messages">
        <?php if (empty($messages)): ?>
            <b>Нет вопросов</b>
        <?php else: ?>
            <div class="comments-container">

                <ul id="comments-list" class="comments-list">

                    <?php foreach ($messages as $msg): ?>
                        <li>
                            <div class="comment-main-level">
                                <!-- Avatar -->
                                <div class="comment-avatar"><img
                                            src="<?= $msg->userData['avatar'] ?>"
                                            alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name by-author"><?= $msg->userData['name'] ?></h6>
                                        <span><?= Yii::$app->formatter->asRelativeTime($msg->created_at) ?></span>
                                        <button type="button" class="btn btn-xs btn-default pull-right respond" data-id="<?=$msg->id?>" data-action="<?=\yii\helpers\Url::to(['/experts/loadform', 'id'=>$msg->id])?>">Ответить
                                        </button>
                                        <?php if(Yii::$app->user->can('Employee')):?>
                                            <button type="button" class="btn btn-xs btn-warning pull-right edit" data-id="<?=$msg->id?>" data-action="<?=\yii\helpers\Url::to(['/experts/edit', 'id'=>$msg->id])?>">Редактировать
                                            </button>
                                        <?php endif;?>
                                    </div>
                                    <div class="comment-content">
                                        <?= $msg->message ?>
                                    </div>
                                </div>
                            </div>
                            <div class="comment_container"></div>

                            <?php if(!empty($data = \common\models\SCExpertMessages::find()->where(['parent'=>$msg->id])->orderBy('created_at DESC')->all()))
                                echo $this->render('_subposts', ['messages'=>$data]);?>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>


        <div class="text-center">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>

    </div>
    <!-- /.box-body -->
</div>

<?php
$js = <<< JS
$('#comments-list').on('click', '.respond', function(){
    $('.comment_container').html('');
    form_container = $(this).closest('li').find('.comment_container').first();
    $.post( $(this).data('action'), function(data){
        form_container.html(data);
    });
});
JS;
$this->registerJs($js);

if(Yii::$app->user->can('Employee')){
    $js = <<< JS
$('#comments-list').on('click', '.edit', function(){
    form_container = $(this).closest('li').find('.comment-content').first();
    $.post( $(this).data('action'), function(data){
        form_container.html(data);
    });
});
JS;
    $this->registerJs($js);
}
?>