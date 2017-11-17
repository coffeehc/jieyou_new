<?php
namespace app\index\validate;
use think\Validate;

class Register extends Validate {
    protected $rule = [
        ['users','require|min:4|max:15','账号不能为空|账号长度最小4位|账号长度不能超过15位'],
        ['password','require|confirm','密码不能为空|两次输入密码不一样'],
        ['email','email','邮箱格式不正确']
    ];

    protected $scene = [
        'add' => ['users','password','email'],
        'checkUser' => ['users'],
    ];
}
