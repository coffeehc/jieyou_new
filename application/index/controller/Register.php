<?php
namespace app\index\controller;
use think\Controller;

class Register extends BaseController {

    public function index() {
        return $this->fetch();
    }
    /**
     * 注册用户
     */
    public function add() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        $validate = validate('Register');
        if(!$validate->scene('add')->check($data)) {
            return show(0,$validate->getError());
        }
        if(model('User')->getUserByUsername($data['users'])) {
            return show(0,'用户名已存在');
        }
        unset($data['password_confirm']);
        try {
            $res = model('User')->save($data);
            if($res) {
                return show(1,'注册成功');
            }else {
                return show(0,'注册失败');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * 用户登录
     * @return [type] [description]
     */
    public function login() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        dump($data);exit;
    }
}
