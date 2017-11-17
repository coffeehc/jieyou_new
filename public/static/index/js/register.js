// 普通注册，手机注册切换
$('.register-tab li').click(function() {
    var lid = $(this).index();
    $(this).addClass('active').siblings().removeClass('active');
    $('.register-tab-con .register-item').hide().eq(lid).show().find('.php-code').click();
});
// 同意用户协议
$('#agreement-reg,#agreement-phone').click(function() {
	var isCheck = $(this).hasClass('icon-cbed');
	var isPhone = $(this).attr('id'), isPhone = isPhone == 'agreement-phone' ? true : false;
	if (isCheck) {
		$(this).removeClass('icon-cbed');
		$(this).parent().siblings('.w-tips').html('<span class="error">请阅读注册协议并勾选同意</span>');
		if (isPhone) {
			$('#submit-phone').attr('disabled','disabled');
		}else{
			$('#submit-reg').attr('disabled','disabled');
		}
	}else{
		$(this).addClass('icon-cbed');
		$(this).parent().siblings('.w-tips').html('');
		if (isPhone) {
			$('#submit-phone').removeAttr('disabled');
		}else{
			$('#submit-reg').removeAttr('disabled');
		}
	}
});
// 普通注册验证
$.validator.addMethod('valid_username', function(value, element){
	return /^[a-zA-Z0-9\u4e00-\u9fa5]{4,15}$/.test(value);
});

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
// 普通注册验证
$('#register-form').validate({
	rules: {
		LOGIN_ACCOUNT: {
			required: true,
			rangelength: [4, 12],
			valid_username: true,
			remote: {
				url: SCOPE.checkUser_url,
				cache: false,
				data: {'do': 'user', 'new': 1, users: function(){ return $('#users').val(); }},
				beforeSend: function(){}
			}
		},
		
		PASSWORD: {
			required: true,
			rangelength: [6, 20]
		},
		
		PASSWORD1: {
			required: true,
			rangelength: [6, 20],
			equalTo: '#pass'
		},
		
		NAME: {
			required: true,
			valid_name: true
		},
		
		ID_CARD_NUMBER: {
			required: true,
			valid_id_card_number: true
		},
	},
	
	messages: {
		LOGIN_ACCOUNT: {
			required: '请填写账号名',
			rangelength: '请填写4-15长度范围的用户名',
			valid_username: '账号名只能由数字或字母组成',
			remote: '账号名已存在'
		},
		
		PASSWORD: {
			required: '请填写密码',
			rangelength: '请输入6-20位范围的密码'
		},
		
		PASSWORD1: {
			required: '请再次输入密码',
			rangelength: '请输入6-20位范围的密码',
			equalTo: '请确认两次输入的密码一致'
		},
		
		NAME: {
			required: '请填写真实姓名',
			valid_name: '真实姓名填写错误，必须为中文'
		},
		
		ID_CARD_NUMBER: {
			required: '输入你的身份证',
			valid_id_card_number: '请填写真实的身份证号码'
		},
	},
    submitHandler: function(form){
        $('#submit-reg').val('注册中...');
		registerAccount();
	},

	success: function(error, element){
		error.removeClass('error').addClass('correct').html('&nbsp;');
	},
	
	errorClass: 'error',
	validClass: 'correct',
	
	errorPlacement: function(error, element) {
		element.closest('.w-item').find('.w-tips').empty().append(error);
	},
	
	invalidHandler: function(event, validator){
		validator.element(validator.errorList[0].element);
	},
	
	onkeyup: false
});

/**
 * 注册用户函数
 */
function registerAccount() {
    var param = {
		'users' : $('.register-account input[name=LOGIN_ACCOUNT]').val(),
		'password' : $('.register-account input[name=PASSWORD]').val(),
		'password_confirm' : $('.register-account input[name=PASSWORD1]').val(),
		'realname' : $('.register-account input[name=NAME]').val(),
        'idcard' : $('.register-account input[name=ID_CARD_NUMBER]').val(),
        'name' : '',
        'email' : '',
    }
    var url = SCOPE.save_url;
	$.post(url, param, function(result) {
        if(result.code == 1) {
            $("body").append(result.data.uc_login);
            layer.msg(result.message,{icon:6,time:1500},function() {
                window.history.back();
            });
        }else {
            layer.msg(result.message,{icon:5,time:1500});
        }
	},'json');
}

// 手机注册验证
$('#register-phone').validate({
	rules: {
		LOGIN_ACCOUNT: {
			required: true,
			rangelength: [11, 12],
			valid_username: true,
			remote: {
				url: SCOPE.checkUser_url,
				cache: false,
				data: {'do': 'user', 'new': 1, users: function(){ return $('#phone').val(); }},
				beforeSend: function(){}
			}
		},
		captcha: {
			required: true,
			rangelength: [4, 4],
			remote: {
				url: SCOPE.checkCaptcha_url,
				cache: false,
				data: {'do': 'user', phone:function(){ return $('#phone').val(); }, captcha: function(){ return $('#captcha').val(); }},
				beforeSend: function(){}
			}
		},
		PASSWORD: {
			required: true,
			rangelength: [6, 20]
		},
		PASSWORD1: {
			required: true,
			rangelength: [6, 20],
			equalTo: '.register-phone input[name=PASSWORD1]'
		},
		NAME: {
			required: true,
			valid_name: true
		},
		ID_CARD_NUMBER: {
			required: true,
			valid_id_card_number: true
		},
	},
	
	messages: {
		LOGIN_ACCOUNT: {
			required: '请填写手机号',
			rangelength: '请填写11位手机号',
			valid_username: '账号名只能由数字组成',
			remote: '账号名已存在'
		},
		captcha: {
			required: '请填写短信验证码',
			rangelength: '请输入4位短信验证码'
		},
		PASSWORD: {
			required: '请填写密码',
			rangelength: '请输入6-20位范围的密码'
		},
		PASSWORD1: {
			required: '请再次输入密码',
			rangelength: '请输入6-20位范围的密码',
			equalTo: '请确认两次输入的密码一致'
		},
		NAME: {
			required: '请填写真实姓名',
			valid_name: '真实姓名填写错误，必须为中文'
		},
		ID_CARD_NUMBER: {
			required: '输入你的身份证',
			valid_id_card_number: '请填写真实的身份证号码'
		},
	},

	submitHandler: function(form){
		$('#submit-phone').val('注册中...');
		registerPhoneAccount();
	},
	
	success: function(error, element){
		error.removeClass('error').addClass('correct').html('&nbsp;');
	},
	
	errorClass: 'error',
	validClass: 'correct',
	
	errorPlacement: function(error, element) {
		element.closest('.w-item').find('.w-tips').empty().append(error);
	},
	
	invalidHandler: function(event, validator){
		validator.element(validator.errorList[0].element);
	},
	
	onkeyup: false
});

/**
 * 发送短信
 */
function sendCaptcha(btn){
	var checkU = $('#phone').siblings('.w-tips').html();
	if (checkU.indexOf('已存在') != -1) {
		return false;
	}
	var phone = $('#phone'), vphone = phone.val(), ptip = phone.closest('.w-item').find('.w-tips'),
		vbtn = $(btn);
	if (vphone.length < 11) {
		ptip.html('<label for="phone" generated="true" class="error">请填写正确手机号</label>')
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
			layer.msg(result.message,{icon:6,time:1000});
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
			layer.msg(result.message,{icon:5,time:1500});
		}
	},'json');
}

/**
 * 手机用户注册
 */
function registerPhoneAccount() {
    var param = {
		'users' : $('#phone').val(),
		'password' : $('#phone_pass').val(),
		'password_confirm' : $('#phone_pass1').val(),
		'realname' : $('#phone_realname').val(),
        'idcard' : $('#phone_idcard').val(),
        'name' : '',
		'email' : '',
		'phone': $('#phone').val(),
	}
    var url = SCOPE.save_url;
	$.post(url, param, function(result) {
        if(result.code == 1) {
            $("body").append(result.data.uc_login);
            layer.msg(result.message,{icon:6,time:1500},function() {
                window.history.back();
            });
        }else {
            layer.msg(result.message,{icon:5,time:1500});
        }
	},'json');
}