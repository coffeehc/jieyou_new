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
    })
})
