<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Открытые задачи</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <select id="userTo" class="form-control">

                </select>
                <textarea id="msg" class="form-control" rows="10"></textarea>
                <button id="send" class="btn btn-success btn-block">Отправить сообщалку</button>
            </div>
        </div>
    </div>
</div>

<?php $js = <<<JS
conn.onmessage = function(e) {
        object = JSON.parse(e.data);
        if(object.type == "online") {
            items = "";
    $.each(object.users, function(index,value){
        items += '<option value="'+value.id+'">'+value.name+'</option>';
    });
    $('#userTo').html(items);
        }
       
    };

$('#send').click(function(){
        msg = $('#msg').val();
        data = {type:"alert", msg:msg, uid:$('#userTo').val()};
        conn.send(JSON.stringify(data));
        console.log(data);
        $('#msg').val('');
        
    });
JS;

$this->registerJs($js);
