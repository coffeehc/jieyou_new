$(function() {
    $(".channel-a").click(function() {
        $(this).addClass('on');
        $(".channel-a").not(this).removeClass("on");
        var type = $(this).attr("date-type");
        $("#bank").val(type);
        if(type == 13) {
            $(".order-title").text("微信支付");
            $(".order-pay-bank").addClass('hide');
            $(".order-pay-card").addClass('hide');
        }else if(type == 14) {
            $(".order-title").text("中国银联");
            $(".order-pay-bank").addClass('hide');
            $(".order-pay-card").addClass('hide');
        }else if(type == 12) {
            $(".order-title").text("支付宝支付");
            $(".order-pay-bank").addClass('hide');
            $(".order-pay-card").addClass('hide');
        }else if(type == 'wy') {
            $(".order-title").text("网上银行");
            $(".order-pay-bank").removeClass('hide');
            $(".order-pay-card").addClass('hide');
        }else if(type == 'card') {
            $(".order-title").text("卡类充值");
            $(".order-pay-card").removeClass('hide');
            $(".order-pay-bank").addClass('hide');
        }
    });
    $(".pay-money").click(function() {
        var money = $(this).attr("date-money");
        $("#money").val(money);
        $(this).addClass('checked');
        $(".pay-money").not(this).removeClass("checked");
    });
    $(".write-money").click(function() {
        $(".pay-money").removeClass("checked");

    })
    $("#else").keyup(function() {
        var money = $(this).val();
        if(money < 0) {
            $(this).val(10);
        }
        if(money > 100000) {
            $(this).val(100000);
        }
        $("#money").val(money);
    })
    $(".pay-bank").click(function() {
        var type = $(this).attr("bank-id");
        $("#bank").val(type);
        $(this).addClass('checked');
        $(".pay-bank").not(this).removeClass("checked");
    })
    $(".pay-card").click(function() {
        var type = $(this).attr("bank-id");
        $("#bank").val(type);
        $(this).addClass('pay-card-on');
        $(".pay-card").not(this).removeClass("pay-card-on");
    });

    /**
     * 点击选择游戏下拉框
     * @return {[type]} [description]
     */
    $("#choosed_game_a").click(function() {
        $(".pay-game").removeClass("pay-game-on");
        $(this).addClass("pay-game-on");
        $(".gs-sel-panel").removeClass("show");
        $("#choosed_game_div").addClass("show");
    });
    $("#choosed_game_div_closed").click(function() {
        $("#choosed_game_div").removeClass("show");
    });

    $("#choosed_server_div_closed").click(function() {
        $("#choosed_server_div").removeClass("show");
    });


    // 游戏字母切换
    function initTab(name) {
        var _tab = $(name);
        _tab.find('.lastplay-items li').click(function() {
            _tab.find(".gs-sel-cate-box").hide().eq($(this).index()).show();
            $(".gs-sel-timeout").hide();
            $(".gs-sel-tab-btn").removeClass("current-tab");
            $(this).children().addClass("current-tab");
        }).eq(0).click();
    };
    initTab("#choosed_game_div");

    /**
     * 点击最近玩过的游戏
     * @return {[type]} [description]
     */
    $("#last-played").click(function() {
        $(".gs-sel-tab-btn").removeClass("current-tab");
        $(this).addClass("current-tab");
        $(".gs-sel-cate-box").hide();
        $(".gs-sel-timeout").show();
    });

    // 服务器切换
    function servertab(name) {
        var _tab = $(name);
        $(".sub-list-main").on('click',"li",function() {
            _tab.find(".server-list-main").hide().eq($(this).index()).show();
            $(".gs-sel-sub-btn").removeClass("current-tab");
            $(this).children().addClass("current-tab");
        });
    }
    servertab("#server_page_l");



    /**
     * 点击游戏
     * @return {[type]} [description]
     */
    $(".game-items").click(function() {
        var game = $(this).text();
        var id = $(this).attr("date-id");
        var gid = $(this).attr("data-gid");
        $("#choosed_game_a").text(game);
        $(".pay-game").removeClass("pay-game-on");
        $(".gs-sel-panel").removeClass("show");
        $("#choosed_server_a").addClass("pay-game-on");
        $("#choosed_server_div").addClass("show");
        var url = SCOPE.choosed_game_url;
        $.post(url,{gid:gid},function(result) {
            if(result.code == 1) {
                var lhtml = [];
                var rhtml = [];
                var lasthtml = [];
                var item = 100;
                var a = 1

                // 判断是否玩过这款游戏
                if(result.data.myservers.length > 0) {
                    $.each(result.data.myservers,function(index,value) {
                        var str = value.name.split("双");
                        lasthtml.push('<li class="gs-sel-ser-item"><a class="server-items">'+'双'+str[1]+'</a></li>');
                    });
                }else {
                    lasthtml.push('<li class="gs-sel-server-empty-tips">你还没有玩过这个游戏哦:)</li>')
                }
                $.each(result.data.allservers,function(index,value) {
                    if(index == result.data.allservers.length - 1) {
                        lhtml.push('<li><a href="javascript:;" class="gs-sel-sub-btn current-tab">'+a+-+item+'服'+'</a></li>');
                        rhtml.push('<ul class="server-list-main" style="display:block;">');
                    }else {
                        lhtml.push('<li><a href="javascript:;" class="gs-sel-sub-btn">'+a+-+item+'服'+'</a></li>');
                        rhtml.push('<ul class="server-list-main" style="display:none;">');
                    }
                    a = item + a;
                    item += 100;
                    $.each(value,function(inx,val) {
                        rhtml.push('<li class="gs-sel-ser-item"><a class="server-items">'+val.name+'</a></li>')
                    });
                    rhtml.push('</ul>');
                });

                $(".sub-list-main").html(lhtml.join(""));
                $(".gs-sel-server-list").html(rhtml.join(""));
                $(".lastplay-list-main").html(lasthtml.join(""));
            }else {
                alert('系统繁忙');
            }
        },'json')
    });

    /**
     * 点击服务器类型 选择服务器类型
     * @return {[type]} [description]
     */
    $("#server_search").click(function() {
        if($("#gs_sel_server_dropdown").hasClass("show")) {
            $("#gs_sel_server_dropdown").removeClass("show");
        }else {
            $("#gs_sel_server_dropdown").addClass("show");
        }
    });
    $(".gs-sel-server-items").click(function() {
        $("#gs_sel_server_dropdown").removeClass("show");
        $("#server_search").text($(this).text());
    });

    /**
     * 点击选择区服下拉框
     * @return {[type]} [description]
     */
    $("#choosed_server_a").click(function() {
        var game = $("#choosed_game_a").text();
        if(game !== '选择游戏') {
            if($("#choosed_server_div").hasClass("show")) {
                $("#choosed_server_div").removeClass("show");
            }else {
                $("#choosed_server_div").addClass("show");
            }
        }else {
            alert("还没有选择游戏");
            return false;
        }
    });

})


function check() {
    var money = document.getElementById("money").value;
    if(money < 10) {
        $("#error-money").css("display","block");
        return false;
    }
    return true;
}
