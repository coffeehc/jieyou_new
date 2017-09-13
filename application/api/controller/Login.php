<?php
namespace app\api\controller;
use think\Controller;

/**
 * 微端登录
 */
class Login extends Controller {

    public function index() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        $username = $data['username'];
        $user = model('User')->getUserByUsername($data['username']);
        if($user && $user['password'] == $data['pwd']) {
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update(['update_time'=>time()]);

            // 解决充值问题
            $res = model('LoginSession')->getLoginSessionInfoByUser($data['username']);
            if($res) {
                model('LoginSession')->where("user = '$username'")->update(['sessionid'=>session_id()]);
            }else{
                model('LoginSession')->insert(['user'=>$username,'sessionid'=>session_id()]);
            }

            // 获取到游戏区服，并返回给登录界面
            $gameServer = model('GameServer')->getGameServerArrayByGid($data['gameid']);

            return show(1,$user['users'].'欢迎您！',$gameServer);
        }else {
            return show(0,'用户名或密码错误');
        }
    }
}
