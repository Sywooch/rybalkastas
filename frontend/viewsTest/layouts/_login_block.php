<?php
use yii\helpers\Url;
?>

<?php if(Yii::$app->user->isGuest):?>
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Вход/Регистрация</h2>',
        'toggleButton' => [
            'label' => 'Вход/Регистрация',
            'tag' => 'button',
            'class'=>'btn btn-default btn-block'


        ],
    ]);

    echo $this->render('//_blocks/_modal_login');

    \yii\bootstrap\Modal::end();
    ?>
<?php else:?>
    <div class="dropdown head_dropdown">
        <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown">
            <?=Yii::$app->user->identity->showNameCustomer?> <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

            <?php if(Yii::$app->user->can('Employee')):?>
                <li style="background: #ffc7c7;"><a href="<?=Yii::$app->params['adminUrl']?>">Админка</a></li>
                <li style="background: #ffc7c7;"><a href="<?=Url::to(['/user/admin'])?>">Управление пользователями</a></li>

            <?php endif;?>

            <li><a href="<?=Url::to(['/user/settings/customer'])?>">Личный кабинет</a></li>
            <li><a href="<?=Url::to(['/user/settings/laterproducts'])?>">Отложенные товары</a></li>
            <li><a data-method="post" href="<?=Url::to(['/site/logout'])?>">Выйти</a></li>
        </ul>
    </div>
<?php endif;?>