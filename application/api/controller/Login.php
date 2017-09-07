<?php
namespace app\api\controller;
use think\Controller;

class Login extends Controller {

    public function index() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        $user = model('User')->getUserByUsername($data['username']);
        if($user && $user['password'] == $data['pwd']) {
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update(['update_time'=>time()]);

            // 获取到游戏区服，并返回给登录界面
            $gameServer = model('GameServer')->getGameServerArrayByGid($data['gameid']);
            
            return show(1,$user['users'].'欢迎您！',$gameServer);
        }else {
            return show(0,'用户名或密码错误');
        }
    }
}
