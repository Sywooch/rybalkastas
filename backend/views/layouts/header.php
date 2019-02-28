<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">TTA</span><span class="logo-lg">Rybalkashop 2.0</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">



        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li>
                    <a>HDD: <b class=""><?=round(disk_free_space("/")/1024/1024/1024)?>GB / <?=round(disk_total_space("/")/1024/1024/1024)?>GB</b></a>
                </li>
                <li>
                    <a>MailSRV: <b class="text-red"><?=ping('165.227.145.160', 80)?'<b class="text-green">Online</b>':'<b class="text-red">Offline</b>'?></b></a>
                </li>
                <li>
                    <a>1CSRV: <b class="text-red"><?=ping('176.107.242.44', 8284)?'<b class="text-green">Online</b>':'<b class="text-red">Offline</b>'?></b></a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="<?=\yii\helpers\Url::to(['trash/index'])?>">Корзина <span class="label label-warning"><?=\common\models\Trash::find()->count()?></span></a>
                </li>
                <li>
                    <a href="<?=\Yii::$app->urlManagerFrontend->createAbsoluteUrl("")?>">Перейти на сайт</a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= \cebe\gravatar\Gravatar::widget([
                            'email' => \Yii::$app->user->identity->email,
                            'options' => [
                                'class'=>'user-image'
                            ],
                            'size' => 32
                        ]) ?>
                        <span class="hidden-xs">    <?php if(\Yii::$app->user->identity):?><?=\Yii::$app->user->identity->profile->name?><?php endif;?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->

                        <li class="user-header">

                            <?= \cebe\gravatar\Gravatar::widget([
                                'email' => \Yii::$app->user->identity->email,
                                'options' => [
                                    'class'=>'img-circle'
                                ],
                                'size' => 160
                            ]) ?>

                            <p>
                                <?=\Yii::$app->user->identity->profile->name?> - <?=\Yii::$app->user->identity->profile->bio?>
                            </p>
                            <p>
                                <?=\Yii::$app->user->identity->profile->assignment?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Профиль',
                                    ['/user/settings/profile'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="toggleSidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>


<?php

function ping($host,$port=80,$timeout=6)
{
    try{
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
    } catch (Exception $e){
        $fsock = false;
    }

    if ( ! $fsock )
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}