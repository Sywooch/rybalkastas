<?php
use yii\helpers\Url;
?>

<?php if(Yii::$app->user->isGuest):?>
    <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#loginModal">Вход/Регистрация</button>
    <div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Вход/Регистрация</h2>
                </div>
                <div class="modal-body">
                    <p><?=$this->render('//_blocks/_modal_login');?></p>
                </div>
            </div>

        </div>
    </div>

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
            <li><a href="<?=Url::to(['/user/settings/requestedproducts'])?>">Ожидаемые товары <span class="badge badge-pill badge-danger"><?=Yii::$app->user->identity->customer->requestedCount?></span></a></li>
            <li><a data-method="post" href="<?=Url::to(['/site/logout'])?>">Выйти</a></li>
        </ul>
    </div>
<?php endif;?>