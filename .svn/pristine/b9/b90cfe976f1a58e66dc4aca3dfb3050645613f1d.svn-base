
$("#hecheng-button-submit-recom").click(function() {
    var checkedNum = $("input[name='box']:checked").length;
    if(checkedNum == 0) {
        dialog.error('还没有选择推荐哦:)');
    }else {
        var ids = '';
        $("input[name='box']:checked").each(function(i) {
            ids += +$(this).val()+',';
        });
        var data = $("#hecheng-form").serializeArray();
        postData = {};
        var tj = 'tj';
        $(data).each(function(i) {
            postData[this.name] = this.value;
        });
        postData[tj] = ids;
        url = SCOPE.save_url;
        jump_url = SCOPE.jump_url;
        $.post(url,postData,function(result) {
            if(result.code == 1) {
                layer.msg(result.message,{icon:6,time:1500},function() {
                    window.location.href = jump_url;
                });
            }else {
                return dialog.error(result.message);
            }
        },'json');
    }
});
