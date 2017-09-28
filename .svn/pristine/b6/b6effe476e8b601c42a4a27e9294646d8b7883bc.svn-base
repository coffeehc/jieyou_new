$(function() {
    $("#sub").click(function() {
        var data = $("#Form1").serializeArray();
        postData = {};
        $(data).each(function(i){
            postData[this.name] = this.value;
        });
        if(postData.username == '') {
            return alert('账号不能为空');
        }
        if(postData.pwd == '') {
            return alert('密码不能为空');
        }
        var url = '/api/Login/index';
        $.post(url,postData,function(result) {
            if(result.code == 1) {
                if(result.data.length > 0) {
                    document.getElementById('loginDiv').style.display='none';
                    var data = eval(result.data);
                    var shtml='<ul class="news2">';
                    for(var i=0; i<data.length;i++){
                        shtml+='<li>'
                            +'<span class="sp1">'
                                +'<a href="/game/'+data[i].id+'_pc.html" title="点击进入游戏">'+data[i].game+data[i].name+'</a>'
                            +'</span>'
                            +'<span class="news-date">'+data[i].create_time+'</span>'
                        +'</li>';
                    }
                    shtml+='</ul>';
                    var gameserverDiv = document.getElementById('gameserver');
                    gameserverDiv.innerHTML=shtml;
                    gameserverDiv.style.display='';
                }else {
                    alert('游戏还未开区');
                }
            }else {
                alert(result.message);
            }
        },'json')
    });
})
