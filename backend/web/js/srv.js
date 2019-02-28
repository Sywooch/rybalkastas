var cid = "";
var conn;
var uid;

$(document).ready(function(){
    conn = new WebSocket('ws://rybalkashop.ru:8001');
    uid = $('meta[name="uid"]').attr('content');
    conn.onmessage = function(e) {
        object = JSON.parse(e.data);
        console.log(e.data);
        if(object.type == "auth"){
            //console.log('Response:' + object.msg);
        } else if(object.type == "msg") {
            //console.log('Response:' + object.msg);
            if($('#container-chat').length){
                renderMessage(object)
            }
        }  else if(object.type == "alert") {
            alert(object.msg);
        }  else if(object.type == "online") {
            console.log(object.users);
            renderOnlineUsers(object.users);
        }
        $('.chat-inner').scrollTop($('#chat-body').height());

    };
    conn.onopen = function(e) {
        console.log("Connection established!");
        console.log('Hey!');
        data = {type:"auth", cipher:uid};
        conn.send(JSON.stringify(data));
    };

    conn.onerror = function(e)
    {
        //alert('Подключение не установлено');
    };
});

function renderOnlineUsers(users)
{
    items = "";
    $.each(users, function(index,value){
        items += '<li>'+
            '<a href="javascript:void(0)">'+
            '<img src="'+value.avatar_url+'">'+
            '<div class="menu-info">'+
            '<h4 class="control-sidebar-subheading">'+value.name+'</h4>'+
        '<p></p>'+
        '</div>'+
        '</a>'+
        '</li>';
    });
    $('#users-online').html(items);
}
