<?php
namespace app\admin\validate;
use think\Validate;

class GameType extends Validate {

    protected $rule = [
        ['name','require','分类名称不能为空'],
    ];

    protected $scene = [
        'add' => ['name'],
    ];
}
