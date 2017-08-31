<?php
namespace app\index\controller;
use think\Controller;

class User extends BaseController {

    /**
     * 初始化 判断用户是否登录
     * @return [type] [description]
     */
    public function _initialize() {
        $isLogin = $this->userIsLogin();
        if(!$isLogin) {
            return $this->error('你还没有登录哦，请先登录');
        }
    }

    public function index() {
        return $this->fetch();
    }
}
