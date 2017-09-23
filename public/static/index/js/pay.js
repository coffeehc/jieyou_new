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
    $("#choosed_game_a").click(function() {
        $(this).addClass("pay-game-on");
        $("#choosed_game_div").addClass("show");
    });
    $("#choosed_game_div_closed").click(function() {
        $("#choosed_game_div").removeClass("show");
    });

    // 游戏字母切换
    function initTab(name) {
        var _tab = $(name);
        _tab.find('.lastplay-items li').click(function() {
            _tab.find(".gs-sel-cate-box").hide().eq($(this).index()).show();
            $(".gs-sel-tab-btn").removeClass("current-tab");
            $(this).children().addClass("current-tab");
        }).eq(0).click();
    };
    initTab("#choosed_game_div");
})
function check() {
    var money = document.getElementById("money").value;
    if(money < 10) {
        $("#error-money").css("display","block");
        return false;
    }
    return true;
}
