<?php
$this->title = 'Пользователи';
use yii\helpers\Url;
?>


<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Пользователи</h3>

    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            <?php foreach($users as $user):?>
            <li>
                <?= \cebe\gravatar\Gravatar::widget([
                    'email' => $user->email,
                    'options' => [
                        'class'=>'user-image'
                    ],
                    'size' => 128
                ]) ?>
                <a class="users-list-name" href="<?=Url::toRoute(['/ouser/user', 'id'=>$user->id])?>"><?php if(!empty($user->profile->name)){echo $user->profile->name;}else{echo $user->username;}?></a>
                <span class="users-list-date"><?=$user->profile->assignment?></span>
            </li>
            <?php endforeach;?>
        </ul><!-- /.users-list -->
    </div><!-- /.box-body -->
    <div class="box-footer text-center">
        <a href="javascript::" class="uppercase">Вывести список</a>
    </div>
</div>