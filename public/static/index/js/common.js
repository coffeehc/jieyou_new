$(function() {
    /**
     * 用户退出平台
     * @return {[type]} [description]
     */
    $("#logout").click(function() {
        $.post(logout_url,{target:1},function(result) {
            if(result.code == 1) {
                layer.msg(result.message,{icon:6,time:1500},function() {
                    window.location.reload();
                });
            }else {
                layer.msg(result.message,{icon:5,time:1500});
            }
        },'json')
    })

    /**
     * 用户注册
     * @return {[type]} [description]
     */
    $("#hecheng-submit").click(function() {
        var data = $("#hecheng-form").serializeArray();
        postData = {};
        $(data).each(function(i) {
            postData[this.name] = this.value;
        });

        url = SCOPE.save_url;
        $.post(url,postData,function(result) {
            if(result.code == 1) {
                layer.msg(result.message,{icon:6,time:1500},function() {
                    window.location.reload();
                });
            }else {
                layer.msg(result.message,{icon:5,time:1500});
            }
        },'json');
    });

    $("#user_index").click(function() {
        var url = $(this).attr("data-url");
        $.post(url,{},function(result) {
            if(result.code == 0) {
                layer.msg('你还没有登录哦，请先登录',{icon:6,time:1500});
            }else {
                window.location.href = url;
            }
        },'json');
    });

});

function addFavorite2(){
    var url = window.location;
    var title = document.title;
    var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf("360se") > -1) {
        alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
    }
    else if (ua.indexOf("msie 8") > -1) {
        window.external.AddToFavoritesBar(url, title); //IE8
    }
    else if (document.all) {
        try{
            window.external.addFavorite(url, title);
        }catch(e){
            alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
        }
    }
    else if (window.sidebar) {
        window.sidebar.addPanel(title, url, "");
    }
    else {
        alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
    }
}
