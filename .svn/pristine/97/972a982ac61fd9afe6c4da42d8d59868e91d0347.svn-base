<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller {

    public function index() {
        $manager = session('manager','','admin');
        if($manager && $manager->id) {
            return $this->redirect('index/index');
        }
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

        if(!$res || $res['status'] != 1 || $res['password'] != md5($data['password'])) {
            return show(0,'用户名或密码错误:(');
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        try {
            model('Manager')->save(['ip'=>$ip,'hits'=>$res['hits']+1],['id'=>$res['id']]);
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }

        // manager session 名称     admin 作用域
        session('manager',$res,'admin');
        return show(1,'登录成功');
    }

    public function logout() {
        session(null,'admin');
        return $this->redirect('login/index');
    }
}
