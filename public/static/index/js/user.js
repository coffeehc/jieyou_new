$.validator.addMethod('valid_name', function(value, element){
	str=value.replace(/ /g,"")
	var reg = /^[\u4E00-\u9FA5]+$/; 
	if(!reg.test(str)){return false}
	return true;
});
//身份证验证
var aCity={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"} 

$.validator.addMethod('valid_id_card_number', function(sId, element){
	var iSum=0
	var info=""
	if(!/^\d{17}(\d|x)$/i.test(sId))return false;
	sId=sId.replace(/x$/i,"a");
	if(aCity[parseInt(sId.substr(0,2))]==null)return false;
	sBirthday=sId.substr(6,4)+"-"+Number(sId.substr(10,2))+"-"+Number(sId.substr(12,2));
	var d=new Date(sBirthday.replace(/-/g,"/"))
	if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate()))return false;
	for(var i = 17;i>=0;i --) iSum += (Math.pow(2,i) % 11) * parseInt(sId.charAt(17 - i),11)
	if(iSum%11!=1)return false;
	return true;
});

/**
 * 邮箱验证
 */
$('#email_form').validate({
	rules: {
		
		email: {
			required: true,
			email: true
		},
	},
	
	messages: {
		
		email: {
			required: '邮箱不能为空',
			email: '邮箱地址不正确',
		},
	},
    submitHandler: function(form){
		var postData = {
			'email': $('#email').val(),
		}
		updateUserInfo(postData);
	},
});

/**
 * 手机验证
 */
$('#mobile_form').validate({
	rules: {
		
		phone: {
			required: true,
			rangelength: [11, 12],
		},
		smscode: {
			required: true,
			rangelength: [4, 4],
			remote: {
				url: SCOPE.checkCaptcha_url,
				cache: false,
				data: {'do': 'user', phone:function(){ return $('#mobile').val(); }, captcha: function(){ return $('#mobileid').val(); }},
				beforeSend: function(){}
			}
		},
	},
	
	messages: {
		
		phone: {
			required: '手机号码不能为空',
			rangelength: '请输入正确得11位手机号码',
		},
		smscode: {
			required: '请填写短信验证码',
			rangelength: '请输入4位短信验证码'
		},
	},
    submitHandler: function(form){
		var postData = {
			'phone': $('#mobile').val(),
		}
		updateUserInfo(postData);
	},
});

$('#password_form').validate({
	rules: {
		
		fik1: {
			required: true,
			rangelength: [6, 20],
			remote: {
				url: SCOPE.checkPassword_url,
				cache: false,
				data: { id:function() {return $('#userid').val()},password: function(){ return $('#oldpw').val(); }},
				beforeSend: function(){}
			}
		},
		
		fik2: {
			required: true,
			rangelength: [6, 20],
		},
		fik3: {
			required: true,
			rangelength: [6, 20],
			equalTo: '#newpw'
		},
	},
	
	messages: {
		
		fik1: {
			required: '请填写原密码',
			rangelength: '请填写6-20位密码',
			remote: '原密码输入不正确',
		},
		
		fik2: {
			required: '请填写新密码',
			rangelength: '请填写6-20位密码',
		},
		fik2: {
			required: '请填写新密码',
			rangelength: '请填写6-20位密码',
			equalTo: '请确认两次输入的密码一致',
		},
	},
    submitHandler: function(form){
		var postData = {'password':$('#newpw_repeat').val()};
		updateUserInfo(postData);
	},
});

/**
 * 实名认证验证
 */
$('#id_form').validate({
	rules: {
		
		realname: {
			required: true,
			valid_name: true
		},
		
		realid: {
			required: true,
			valid_id_card_number: true
		},
	},
	
	messages: {
		
		realname: {
			required: '请填写真实姓名',
			valid_name: '真实姓名填写错误，必须为中文'
		},
		
		realid: {
			required: '输入你的身份证',
			valid_id_card_number: '请填写真实的身份证号码'
		},
	},
    submitHandler: function(form){
        var postData = {
			'realname': $('#realname').val(),
			'idcard': $('#realid').val(),
		}
		updateUserInfo(postData);
	},

});

$("#avatar_form").validate({
	rules: {
		
		pic: {
			required: true,
		},
		
	},
	
	messages: {
		
		pic: {
			required: '没有选择头像',
		},
	},
    submitHandler: function(form){
	   var postData = {
		   'pic': $('#pic').val(),
	   }
	   updateUserInfo(postData);
	},
});

/**
 * 发送验证码
 * @param  btn 
 */
function sendSms(btn) {
	var phone = $('#mobile'), vphone = phone.val(), vbtn = $(btn);
	if (vphone.length < 11) {
		return false;
	}else{
		// ptip.html('');
	}
	var param = {
		'phone' : vphone,
    }
    var url = SCOPE.sendSms_url;
	$.post(url, param, function(result) {
		if (result.code == 1) {
			vbtn.attr('disabled','disabled').addClass('w-button-disabled');
			capt_cd = 120;
			var capt_timer = setInterval(function(){
				capt_cd--;
				vbtn.val(capt_cd+'秒后重试');
 				if (capt_cd == 0) {
					vbtn.val('发送验证码').removeAttr('disabled').removeClass('w-button-disabled');
					clearInterval(capt_timer);
					$('.register-phone .php-code').click();
					code.val('').focus().closest('.w-item').find('.w-tips').html('');
				}
			},1000);
		}else{
			alert(result.message);
		}
	},'json');
}

/**
 * 更新用户数据
 * @param  data 
 */
function updateUserInfo(data) {
	data.id = $('#userid').val();
	var url = SCOPE.update_url;
	$.post(url,data,function(result) {
		if(result.code == 1) {
			window.location.reload();
		}else {
			alert(result.message);
		}
	},'json');
}

/**
 * 选择头像
 */
$('.psdBox .item').click(function() {
	var pic = $(this).find('img').attr('src');
	$("#userpic").attr('src',pic);
	$("#pic").val(pic);
});

/**
 * 退出操作
 */
$('#logout').click(function() {
	var url = SCOPE.logout_url;
	$.post(url,{target:1},function(result) {
		if(result.code == 1) {
			window.location.href = '/';
		}else {
			alert(result.message);
		}
	},'json')
});
