<?php
namespace app\admin\validate;
use think\Validate;

class GameServer extends Validate {
    protected $rule = [
        ['sid','require','开区编号不能为空'],
        ['create_time','require','开区时间不能为空'],
        ['gid','require','还没选择游戏:)'],
    ];
    protected $scene = [
        'add' => ['sid','create_time','gid'],
    ];
}
