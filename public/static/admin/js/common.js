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
