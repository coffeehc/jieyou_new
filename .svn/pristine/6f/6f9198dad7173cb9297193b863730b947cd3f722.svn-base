<?php
namespace app\admin\validate;
use think\Validate;

class Link extends Validate {
    protected $rule = [
        ['id','number'],
        ['name','require','网站名称不能为空'],
        ['url','require|url','网站链接不能为空|链接格式错误']
    ];

    protected $scene = [
        'add' => ['name','url'],
    ];
}
