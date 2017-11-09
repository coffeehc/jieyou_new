$(function() {
	// 登录操作
	$("#user-login-submit1").click(function () {
		var users = $("#users").val();
		var password = $("#password").val();
		var url = SCOPE.login_url;
		
		if(users == '请输入用户名') {
			$("#login_tip").text("请输入用户名!");
			return;
		}
		$.post(url,{users:users,password,password},function(result) {
			if(result.code == 1) {
				window.location.reload();
			}else {
				$("#login_tip").text(result.message);
			}
		},'json')
	});

	// 获取礼包
	$("#submit").click(function() {
		$("#cardInfo").text('礼包获取中。。。');
		var gsid = $("#gsid").val();
		var url = SCOPE.getgift_url;
		$.post(url,{gsid:gsid},function(result) {
			if(result.code == 1) {
				$("#cardInfo").text(result.message);
			}else {
				$("#cardInfo").text(result.message);
			}
		},'json')
	});
})

//快速进入区服
function passport(){
	var snum = $('#snum').val();
	if(snum==''||snum==0||snum=='undefined'||snum=='选择服务器'){
		alert('请输入服务器编号');
		return;
	}
	var gid = $("#gid").val();
	var url = SCOPE.getserver_url;
	$.post(url,{sid:snum,gid:gid},function(result) {
		if(result.code == 1) {
			window.location.href = '/index/game/index/id/'+result.message+'.html';
		}else {
			alert(result.message);
		}
	},'json');
}

//内容页选项卡
$(function(){
    var data = new Array;
	var newData = new Array;
	data[0]="0";
	data[1]="117px";
	data[2]="238px";
	data[3]="359px";
	newData[0]="140px";
	newData[1]="302px";
	newData[2]="464px";
	newData[3]="626px";
	newData[4]="788px";
	var dataDa = $('.data-h').attr('data');
	var newDa = $('.new-h').attr('data');
    var cur=$('.cont-tab').find('li.current').index();
    $('.new-h').css({"left":data[cur]});

	$.each($('.data-tab li.data-qh'),function(key,val){
		$(this).hover(function(){
			$('.new-h').css({"left":data[key]});
			$('.cont-tab-cont').find('div').hide();
			$('.cont-tab-cont').find('div:eq('+key+')').show();
            });
	});
	
	$.each($('.new-tab li'),function(keys,vals){
	    $(this).hover(function(){
		    $('.new-h').css({"left":data[keys]});
		},function(){
		    $('.new-h').css({"left":data[cur]});
		});
	})
	

})