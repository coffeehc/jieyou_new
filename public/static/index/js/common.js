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
