function getGift(gsid) {
    $("#giftLayer").css('display','block');
    $("#giftNo").val("数据请求中...");

    var url = SCOPE.get_url;
    $.post(url,{gsid:gsid},function(result) {
        if(result.code == 1) {
            $("#giftNo").val(result.message);
        }else {
            $("#giftNo").val(result.message);
        }
    },'json');
}
