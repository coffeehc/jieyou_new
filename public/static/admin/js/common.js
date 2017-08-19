/*时间插件冲突处理*/
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
 }
/**
 *  弹窗式 添加
 * @param {[type]} title [窗口标题]
 * @param {[type]} url   [页面路径]
 * @param {[type]} w     []
 * @param {[type]} h     [description]
 */
function window_add(title,url,w,h) {
    layer_show(title,url,w,h);
}

/**
 *  删除操作
 * @param  {[type]} url [地址]
 * @param  {[type]} id  [主键]
 * @return {[type]}     [description]
 */
function hecheng_del(obj,url,id) {
    layer.confirm('确认要删除吗？',function(index) {
        $.post(url,{id:id},function(result) {
            if(result.code == 1) {
                $(obj).parents("tr").remove();
                layer.msg(result.message,{icon:1,time:1000});
            }else {
                dialog.error(result.message);
            }
        },'json');
    });
}

/**
 * 提交表单操作
 * @return {[type]} [description]
 */
$("#hecheng-button-submit").click(function() {
    var data = $("#hecheng-form").serializeArray();
    postData = {};
    $(data).each(function(i) {
        postData[this.name] = this.value;
    });

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
});
