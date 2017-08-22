<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller {

    public function index() {
        return $this->fetch();
    }

    /**
     * 检查登录
     * @return [type] [description]
     */
    public function check() {
        $data = input('post.');
        $validate = validate('Login');
        if(!$validate->scene('login')->check($data)) {
            return show(0,$validate->getError());
        }

        try {
            $res = model('Manager')->getManagerByUsername($data['manager']);
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }

        if(!$res || $res['status'] != 1 || $res['password'] != md5($data['manager'])) {
            return show(0,'用户名或密码错误:(');
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        try {
            model('Manager')->save(['ip'=>$ip,'hits'=>$res['hits']+1],['id'=>$res['id']]);
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }

        session('manager',$res);
        return show(1,'登录成功');
    }
}
