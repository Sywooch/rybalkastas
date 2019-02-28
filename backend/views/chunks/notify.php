<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-bell-o"></i>
        <?php if(\Yii::$app->user->identity->profile->notifications):?>
        <span class="label label-warning"><?=count(\Yii::$app->user->identity->profile->notifications)?></span>
        <?php endif;?>
    </a>
    <ul class="dropdown-menu">
        <?php if(!\Yii::$app->user->identity->profile->notifications):?>
            <li class="header">У вас нет новых уведомлений</li>
        <?php else:?>
            <li class="header">У вас <?=count(\Yii::$app->user->identity->profile->notifications)?> уведомлений</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                    <ul class="menu" style="overflow: auto; width: 100%; height: 200px;">
                       <?php $i=0;foreach(\Yii::$app->user->identity->profile->notifications as $n):?>
                        <li>
                            <a href="#">
                                <?php if(!empty($n->user)):?>
                                    <i class="fa fa-users text-aqua"></i> <?=(!empty($n->user->profile->name))?$n->user->profile->name:$n->user->username?> <br>
                               <?php endif;?>
                                 <?=$n->content;?>
                            </a>
                        </li>
                           <?php $i++;if($i >= 20)break;?>
                        <?php endforeach;?>
                    </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
            </li>
        <?php endif;?>
    </ul>
</li>