<?php
namespace app\index\controller;
use think\Controller;

class Search extends BaseController {

    public function index() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }

        $gameName = input('post.');
        
    }
}
