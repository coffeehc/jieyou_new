$(function() {
    /**
     * 用户退出平台
     * @return {[type]} [description]
     */
    $("#header_user").on('click','#logout',function() {
        var html = [];
        var hhtml = [];
        html.push('<form id="user-login-form"><table width="100%" border="0" cellspacing="1" cellpadding="0"><tr><td colspan="2"><span class="hei18B">用户登陆</span><br /><hr size="1px" style="height:1px" /></td></tr>');
        html.push('<tr><td width="82">帐号：</td><td width="215"><label><input name="users" type="text" id="users"/></label></td></tr>');
        html.push('<tr><td>密码：</td><td><input name="password" type="password" id="password" /></td></tr>');
        html.push('<tr><td>&nbsp;</td><td><label><input type="button" id="user-login-submit" value="-= 登陆 =-" /></label>');
        html.push('<label style="margin-left:5px;"><input type="button" id="user-register-button" value="-= 注册 =-" /></label></td></tr>');
        html.push('<tr><td colspan="2" style="text-align:center;"><hr size="1px" style="height:1px" /><span class="hei14B">使用第三方登录</span></td></tr>');
        html.push('<tr><td colspan="2"><ul class="clear_here"><li class="o_qq"><a href="/qqlogin/index/index.html">QQ账号登录</a></li><li class="o_wechat"><a href="/wxlogin/index/index.html">微信账号登录</a></li><li class="o_weibo"><a href="/wblogin/index/index.html">新浪微博账号</a></li></ul></td></tr>');
        hhtml.push('<a href="/#user-login-form">登陆</a> | <a href="/index/register/index.html">注册</a>|<a href="javascript:;" onclick="addFavorite2()">加入收藏</a>');
        $.post(logout_url,{target:1},function(result) {
            if(result.code == 1) {
                $("body").append(result.data.uc_logout);
                layer.msg(result.message,{icon:6,time:1500},function() {
                    $(".touming2").html(html.join(""));
                    $("#header_user").html(hhtml.join(""));
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
                $("body").append(result.data.uc_login);
                layer.msg(result.message,{icon:6,time:1500},function() {
                    window.history.back();
                });
            }else {
                layer.msg(result.message,{icon:5,time:1500});
            }
        },'json');
    });

    /**
     * 顶部导航用户中心按钮
     * @return {[type]} [description]
     */
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

    /**
     * banner 上登录操作
     * @return {[type]} [description]
     */
    $(".touming2").on('click','#user-login-submit',function() {
        if ($("#users").val().length == 0) {
            return $("#users").addClass('waring-input');
        }
        if ($("#password").val().length == 0) {
            return $("#password").addClass('waring-input');
        }
        var data = $('#user-login-form').serializeArray();
        var url = SCOPE.login_url;
        postData = {};
        $(data).each(function(i) {
            postData[this.name] = this.value;
        });
        var html = [];  // 用户框
        var hhtml = []; // 顶部
        html.push('<table width="100%" border="0" cellspacing="3" cellpadding="0">');
        html.push('<tr><td colspan="2" class="hei18B">玩家信息</td></tr>');
        html.push('<tr>');
        hhtml.push();
        $.post(url, postData, function(result) {
            if (result.code == 1) {
                $(".touming2").append(result.data.uc_login);
                // console.log(result.data);return;
                if(result.data.user.pic == "") {
                    html.push('<td width="29%"><img src="/images/nopic.jpg" width="90" height="90" /></td>');
                    hhtml.push('<img src="/images/nopic.jpg" width="30"  align="absmiddle"  style="border-radius: 15px;overflow:hidden" />');
                }else {
                    html.push('<td width="29%"><img src="'+result.data.user.pic+'" width="90" height="90" /></td>');
                    hhtml.push('<img src="'+result.data.user.pic+'" width="30"  align="absmiddle"  style="border-radius: 15px;overflow:hidden" />');
                }
                html.push('<td width="71%" class="hei12"><div>昵称：'+result.data.user.name+'</div><div>QQ号：'+result.data.user.qq+'</div><div>邮箱：'+result.data.user.email+'</div><div>登陆次数：'+result.data.user.hits+'</div></td>');
                html.push('<tr><td colspan="2" class="hei18B">最近玩过的游戏</td>');
                // 构建最近玩过的游戏 html
                $.each(result.data.lastplay,function(index,val) {
                    html.push('<tr><td nowrap="nowrap"><a href="/index/game/index/id/'+val.gsid+'.html" title="点击进入游戏" target="_blank"><span class="hei12">'+val.name+'</span></a></td><td align="right"><span class="hei12">'+val.update_time+'</span></td></tr>');
                });
                html.push('</tr>');
                html.push('</table>');
                hhtml.push(':欢迎您！ | <a href="/index/user/index.html" title="用户中心">用户中心</a> | <span id="logout" title="点击退出平台">退出平台</span> |');
                hhtml.push('<a href="javascript:;" onclick="addFavorite2()">加入收藏</a>');
                layer.msg(result.message, {icon: 6,time: 1000}, function() {
                    $(".touming2").html(html.join(""));
                    $("#header_user").html(hhtml.join(""));
                });
            } else {
                layer.msg(result.message, {icon: 5,time: 1500});
            }
        }, 'json')
    });

    /**
     * 注册按钮
     * @return {[type]} [description]
     */
    $(".touming2").on('click','#user-register-button',function() {
        var url = SCOPE.register_url;
        window.location.href = url;
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
