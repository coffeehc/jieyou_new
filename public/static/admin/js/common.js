/*时间插件冲突处理*/
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else if(flag==3){
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:00:00'})}
    }else {
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
 * 批量删除
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function hecheng_dels(url) {
    var checkedNum = $("input[name='box']:checked").length;
    if(checkedNum == 0) {
        dialog.error('请至少选择一项:)');
    }else {
        var ids = '';
        $("input[name='box']:checked").each(function(i) {
            ids += +$(this).val()+',';
        });
        layer.confirm('确定要删除吗?',function() {
            $.post(url,{ids:ids},function(result) {
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

/**
 * 禁用操作
 * @param  {[type]} obj    [description]
 * @param  {[type]} id     [description]
 * @param  {[type]} status [description]
 * @return {[type]}        [description]
 */
function hecheng_stop(obj,id,status){
	var url = SCOPE.status_url;
	layer.confirm('确认要禁用吗？',function(index){
		$.post(url,{id:id,status:status},function(result) {
			if(result.code == 1) {
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="hecheng_start(this,'+id+',1)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe615;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已禁用</span>');
				$(obj).remove();
				layer.msg('已禁用!',{icon: 5,time:1000});
			}else {
				dialog.error(result.message);
			}
		},'json');
	});
}

/**
 * 启用操作
 * @param  {[type]} obj    [description]
 * @param  {[type]} id     [description]
 * @param  {[type]} status [description]
 * @return {[type]}        [description]
 */
function hecheng_start(obj,id,status){
	var url = SCOPE.status_url;
	layer.confirm('确认要启用吗？',function(index){
		$.post(url,{id:id,status:status},function(result) {
			if(result.code == 1) {
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="hecheng_stop(this,'+id+',0)" href="javascript:;" title="禁用"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			}else {
				dialog.error(result.message);
			}
		},'json');
	});
}

/**
 * 修改操作
 * @param  {[type]} title [description]
 * @param  {[type]} url   [description]
 * @param  {[type]} w     [description]
 * @param  {[type]} h     [description]
 * @return {[type]}       [description]
 */
function hecheng_edit(title,url,w,h) {
    layer_show(title,url,w,h);
}

/*打开新页面*/
function hecheng_open(title,url,w,h){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
