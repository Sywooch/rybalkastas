<div class="user<?php if($conv->_id == $model->_id):?> active<?php endif;?>" data-convid="<?=$model->_id?>">


    <?php if($model->isConv):?>
        <div class="avatar">
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
        </div>
        <div class="name"><?=$model->name?></div>
        <div class="mood">Беседа</div>
    <?php else:?>
        <div class="avatar">
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="User name">
            <div class="status off"></div>
        </div>
        <div class="name"><?=$model->user->profile->name?></div>
        <div class="mood"><?=$model->user->username?></div>
    <?php endif;?>

</div>