<?php
namespace app\admin\validate;
use think\Validate;

class Link extends Validate {
    protected $rule = [
        ['id','number'],
        ['name','require','网站名称不能为空'],
        ['url','require','网站链接不能为空']
    ];

    protected $scene = [
        'add' => ['name','url'],
    ];
}
