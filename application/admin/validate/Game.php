<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 游戏验证
 */
class Game extends Validate{

    protected $rule = [
        ['name','require','游戏名称不能为空'],
        ['gid','require','游戏编号不能为空'],
    ];

    protected $scene = [
        'add' => ['name','gid'],
    ];
}
