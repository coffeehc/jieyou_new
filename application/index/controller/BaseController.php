<?php
namespace app\index\controller;
use think\Controller;

class BaseController extends Controller {
    private $user;
    public function _initialize() {
        // 配置信息
        $config = model('Config')->getConfigInfo();
        $this->assign('config',$config);

        // banner 图
        $banner = model('Adimg')->getBannerImg();
        $this->assign('banner',$banner);

        // 判断用户是否登录
        $userIsLogin = $this->userIsLogin();
        if($userIsLogin) {
            $this->assign('user',$this->getLoginUser());
        }else {
            $this->assign('user',$userIsLogin);
        }
    }

    public function userIsLogin() {
        $user = $this->getLoginUser();
        if($user && $user->id) {
            return true;
        }
        return false;
    }

    public function getLoginUser() {
        if(!$this->user) {
            $this->user = session('user','','index');
        }
        return $this->user;
    }
}
