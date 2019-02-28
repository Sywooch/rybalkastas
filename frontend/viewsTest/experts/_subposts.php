<ul class="comments-list reply-list">
    <?php foreach ($messages as $msg): ?>
        <li>
            <div class="comment-main-level">
                <!-- Avatar -->
                <div class="comment-avatar"><img
                        src="<?= $msg->userData['avatar'] ?>"
                        alt=""></div>
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