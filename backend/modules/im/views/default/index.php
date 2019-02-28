<?php

\backend\modules\im\assets\ImAsset::register($this);

?>

<div id="container-chat" class="content container-fluid bootstrap snippets">
    <div class="row flex">
        <div class="col-sm-3 col-xs-12">
            <div class="col-inside-lg decor-default chat" style="overflow: hidden; outline: none;" tabindex="5000">
                <div class="chat-users chat-inner">
                    <h6>Пользователи</h6>
                    <?php foreach ($conversations as $conversation):?>
                        <?=$this->render('_chat_conversation', ['model'=>$conversation, 'conv'=>$conv])?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-xs-12 chat" style="overflow: hidden; outline: none;" tabindex="5001">
            <div id="conv" class="col-inside-lg decor-default chat-inner">
                <?=$this->render('_chat', ['conv'=>$conv, 'msgs'=>$msgs])?>
            </div>
            <div class="input-group">
                <textarea id="msgContainer" class="form-control custom-control" rows="3" style="resize:none"></textarea>
                <span id="sendMsg" class="input-group-addon btn btn-primary">Send</span>
            </div>
        </div>
    </div>
</div>

<?php
$urlLoad = \yii\helpers\Url::to(['load']);
$uid = base64_encode(Yii::$app->user->id.Yii::$app->params['chat_secret']);
$id = $conv->getPrimaryKey();
$js = <<< JS
cid = "$id";
$('.chat-inner').niceScroll();
$('.chat-inner').scrollTop($('#chat-body').height());    
    $('#container-chat').on('click', '#sendMsg', function(){
        msg = $('#msgContainer').val();
        data = {type:"msg", msg:msg, cid:cid};
        conn.send(JSON.stringify(data));
        msg = $('#msgContainer').val('');
    });
    
    $(document).keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
            msg = $('#msgContainer').val();
            data = {type:"msg", msg:msg, cid:cid};
            conn.send(JSON.stringify(data));
            msg = $('#msgContainer').val('');
        }
    });
var timeagoInstance = timeago();
timeagoInstance.render(document.querySelectorAll('.time'), 'ru');


$('.chat-users').on('click','.user',function(e){
    conv = $(this).data('convid');
    $('.user').removeClass('active');
    $(this).addClass('active')
    $.ajax({
      type: "POST",
      url: "$urlLoad",
      data: {conv:conv},
      success: function(data){
          $('#conv').html(data);
          cid = conv;
          var timeagoInstance = timeago();
            
            timeagoInstance.render(document.querySelectorAll('.time'), 'ru');
            $('.chat-inner').niceScroll().resize();
            $('.chat-inner').scrollTop($('#chat-body').height());
            
      },
    });
});
JS;
$this->registerJs($js);
?>

<script>
    function renderMessage(object)
    {
        var timeagoInstance = timeago();
        var itemTpl = $('script[data-template="chat_item"]').text().split(/\$\{(.+?)\}/g);
        if(object.self === 1){
            side = 'right';
        } else {
            side = 'left';
        }
        var items = [{
            side: side,
            username: object.from,
            msg: object.msg,
            timeago: object.ts,
            avatar: object.avatar_url
        }];
        $('#chat-body').append(items.map(function(item) {
            return itemTpl.map(render(item)).join('');
        }));
        $('.chat-body').niceScroll().resize();
        timeagoInstance.render(document.querySelectorAll('.time'), 'ru');

    }

    function render(props) {
        return function(tok, i) {
            return (i % 2) ? props[tok] : tok;
        };
    }
</script>


<script type="text/template" data-template="chat_item">
    <div class="answer ${side}">
        <div class="avatar">
            <img src="${avatar}" alt="User name">
            <div class="status offline"></div>
        </div>
        <div class="name">${username}</div>
        <div class="text">
            ${msg}
        </div>
        <div class="time">${timeago}</div>
    </div>
</script>
