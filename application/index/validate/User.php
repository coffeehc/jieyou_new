<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate {

    protected $rule = [
        ['id','require|number','ID不能为空|ID不合法'],
        ['password','min:6|max:12','密码不能小于6位|密码不能大于12位'],
        ['email','email','email格式不正确'],
        ['qq','number','QQ格式错误']
    ];

    protected $scene = [
        'edit' => ['id','password','email'],
    ];
}
