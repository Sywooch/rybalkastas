<h6><?=$conv->title?></h6>

<div id="chat-body" class="chat-body">
    <?php foreach($msgs as $msg):?>
        <div class="answer <?= $msg->isMe?"right":"left"?>">
            <div class="avatar">
                <?php
                if (strpos($msg->user->profile->getThumbUrl(30, 30), 'data:') !== false):?>
                    <img src="<?=$msg->user->profile->getThumbUrl(30, 30)?>">
                <?php else:?>
                    <img src="http://rybalkashop.ru<?=$msg->user->profile->getThumbUrl(30, 30)?>">
                <?php endif;?>
                <div class="status offline"></div>
            </div>
            <div class="name"><?=$msg->isMe?"Я":$msg->user->showName?></div>
            <div class="text">
                <?=$msg->content?>
            </div>
            <div class="time" datetime="<?=date("Y-m-d H:i:s", $msg->timestamp)?>"></div>
        </div>
    <?php endforeach;?>
</div>

