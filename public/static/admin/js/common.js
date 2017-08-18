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
function hecheng_del(url,id) {
    layer.confirm('确认要删除吗？',function(index) {
        $.post(url,{id:id},function(result) {
            if(result.code == 1) {
                layer.msg(result.message,{icon:6,time:1500},function() {
                    window.location.reload();
                });
            }else {
                dialog.error(result.message);
            }
        },'json');
    });
}
