<?php
namespace app\admin\validate;
use think\Validate;

class Login extends Validate {

    protected $rule = [
        ['manager','require','账号不能为空'],
        ['password','require','密码不能为空'],
        ['captcha','require|captcha','验证码不能为空'],
    ];

    protected $scene = [
        'login' => ['manager','password','captcha'],
    ];
}
