<?php
namespace app\index\validate;
use think\Validate;

class Register extends Validate {
    protected $rule = [
        ['users','require|min:6|max:12','账号不能为空|账号长度最小6位|账号长度不能超过12位'],
        ['password','require|confirm','密码不能为空|两次输入密码不一样'],
        ['email','email','邮箱格式不正确']
    ];

    protected $scene = [
        'add' => ['users','password','email']
    ];
}
