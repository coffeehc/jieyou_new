<?php
namespace app\admin\validate;
use think\Validate;

class Manager extends Validate {
    protected $rule = [
        ['manager','require','登录名不能为空'],
        ['name','require','昵称不能为空'],
        ['password','require|confirm','密码不一致'],
        ['email','email','邮箱格式错误'],
    ];
    protected $scene = [
        'add' => ['manager','name','password','email'],
    ];
}
