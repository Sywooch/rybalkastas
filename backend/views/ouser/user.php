<?php
    use yii\helpers\Url;
?>

<?php
    $this->title = (!empty($model->profile->name))?$model->profile->name:$model->username;
?>

<section class="content">

<div class="row">
<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <?= \cebe\gravatar\Gravatar::widget([
                'email' => $model->email,
                'options' => [
                    'class'=>'profile-user-img img-responsive img-circle'
                ],
                'size' => 128
            ]) ?>
            <h3 class="profile-username text-center"><?=(!empty($model->profile->name))?$model->profile->name:$model->username?></h3>
            <p class="text-muted text-center"><?=$model->profile->assignment?></p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Наблюдающие</b> <a data-toggle="collapse" href="#followersExt" aria-expanded="false" aria-controls="followersExt" class="pull-right"><?=count($model->profile->followers)?></a>
                    <div class="collapse" id="followersExt">
                        <div class="well">
                            <?php foreach($model->profile->followers as $f):?>
                                <div class="col-md-4 text-center">
                                <?= \cebe\gravatar\Gravatar::widget([
                                    'email' => $f->email,
                                    'options' => [
                                        'class'=>'user-image'
                                    ],
                                    'size' => 64
                                ]) ?>
                                <a class="users-list-name" href="<?=Url::toRoute(['/ouser/user', 'id'=>$f->id])?>"><?php if(!empty($f->profile->name)){echo $f->profile->name;}else{echo $f->username;}?></a>
                                </div>
                            <?php endforeach;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <b>Наблюдает</b> <a data-toggle="collapse" href="#followingExt" aria-expanded="false" aria-controls="followingExt" class="pull-right"><?=count($model->profile->following)?></a>
                    <div class="collapse" id="followingExt">
                        <div class="well">
                            <?php foreach($model->profile->following as $f):?>
                                <div class="col-md-4 text-center">
                                    <?= \cebe\gravatar\Gravatar::widget([
                                        'email' => $f->email,
                                        'options' => [
                                            'class'=>'user-image'
                                        ],
                                        'size' => 64
                                    ]) ?>
                                    <a class="users-list-name" href="<?=Url::toRoute(['/ouser/user', 'id'=>$f->id])?>"><?php if(!empty($f->profile->name)){echo $f->profile->name;}else{echo $f->username;}?></a>
                                </div>
                            <?php endforeach;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </li>
            </ul>
            <?php if($model->id <> Yii::$app->user->identity->getId()):?>
                <?php if(!Yii::$app->user->identity->profile->isFollowing($model->id)):?>
                    <a href="#" id="followuser" data-user="<?=$model->id?>" class="btn btn-primary btn-block follow followuser"><b>Наблюдать за пользователем</b></a>
                <?php else:?>
                    <a href="#" id="unfollowuser" data-user="<?=$model->id?>" class="btn btn-warning btn-block follow unfollowuser"><b>Отменить наблюдение</b></a>
                <?php endif;?>

            <?php endif;?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- About Me Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Информация</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i>  О пользователе</strong>
            <p class="text-muted">
                <?=$model->profile->bio?>
            </p>

            <hr>

            <strong><i class="fa fa-pencil margin-r-5"></i> Достижения</strong>
            <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
            </p>

            <hr>

            <strong><i class="fa fa-file-text-o margin-r-5"></i> Статистические данные</strong>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<div class="col-md-9">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#activity" data-toggle="tab">Активность</a></li>
    <li><a href="#timeline" disabled data-toggle="tab">Временная шкала</a></li>
</ul>
<div class="tab-content">
<div class="active tab-pane" id="activity">
    <!-- Post -->
    <?php foreach($activity as $a):?>
    <div class="post clearfix">
        <div class="user-block">
            <?= \cebe\gravatar\Gravatar::widget([
                'email' => $a->user->email,
                'options' => [
                    'class'=>'img-circle img-bordered-sm'
                ],
                'size' => 40
            ]) ?>
                        <span class="username">
                          <a href="#"><?=(!empty($model->profile->name))?$model->profile->name:$model->username?></a>
                        </span>
            <span class="description"><?=$a->date;?></span>
        </div><!-- /.user-block -->
        <p>
            <?=$a->content;?>
        </p>
        <p>
            <?=$a->customContent;?>
        </p>
        <ul class="list-inline">
            <li class="pull-right"><a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Комментарии (0)</a></li>
        </ul>

        <input class="form-control input-sm" type="text" placeholder="Оставить комментарий">
    </div><!-- /.post -->
    <?php endforeach;?>

</div><!-- /.tab-pane -->
<div class="tab-pane" id="timeline">
    <!-- The timeline -->

</div><!-- /.tab-pane -->


</div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
</div><!-- /.row -->

<?php
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () {
    $("[data-toggle='tooltip']").tooltip();
});;
/* To initialize BS3 popovers set this below */
$(function () {
    $("[data-toggle='popover']").popover();
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

$js = '
$(function(){
    $(".follow").click(function(){
        $btn = $(this);
        if($btn.hasClass("followuser")){
            $.ajax({
              type: "POST",
              url: "'.Url::toRoute(['/ouser/follow', 'id'=>$model->id]).'",
              success: function(){
                    $btn.removeClass("btn-primary").addClass("btn-warning");
                    $btn.html("<b>Отменить наблюдение</b>");
                    $btn.removeClass("followuser").addClass("unfollowuser");
              },
            });
        } else {
            $.ajax({
              type: "POST",
              url: "'.Url::toRoute(['/ouser/unfollow', 'id'=>$model->id]).'",
              success: function(){
                $btn.removeClass("btn-warning").addClass("btn-primary");
                    $btn.html("<b>Наблюдать за пользователем</b>");
                    $btn.removeClass("unfollowuser").addClass("followuser");
              },
            });
        }

    });


});
';
$this->registerJs($js);
?>