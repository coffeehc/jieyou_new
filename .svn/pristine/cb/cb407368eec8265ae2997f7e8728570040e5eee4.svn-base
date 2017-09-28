<?php
namespace app\admin\validate;
use think\Validate;

class Apikey extends Validate {

        protected $rule = [
            ['pid','require','代理ID号不能为空'],
            ['name','require','平台名称不能为空'],
            ['apikey','require','APIKEY不能为空'],
            ['paykey','require','PAYKEY不能为空'],
        ];

        protected $scene = [
            'add' => ['pid','name','apikey','paykey'],
        ];
}
