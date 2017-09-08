<?php
namespace app\ad\controller;
use think\Controller;

class Game extends Controller {

    /**
     * 登录主页面
     * @return [type] [description]
     */
    public function index() {
        $data = input('param.');
        if(isset($data['gid']) && $data['gid'] != '') {
            $flashInfo = model('Flash')->getFlashInfoByGid($data['gid']);

            return $this->fetch('',[
                'flashInfo' => $flashInfo,
            ]);
        }else {
            return '没有相关游戏:)';
        }


    }

    /**
     * 内嵌FLASH页面
     * @return [type] [description]
     */
    public function main() {
        return $this->index();
    }

    public function login() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }

        $data = input('post.');
        if($data['type'] == 'userconfirm') {
            if(!preg_match("/^[a-zA-Z0-9]\S*\d$/",$data['users'])) {
                return show(0,'用户名只能以数字或字母开头');
            }
            if(strpos($data['users']," ")) {
                return show(0,'用户名中不能有空格');
            }
            $user = model('User')->getUserByUsername($data['users']);

            if($user) {
                return show(0,'用户名已经被注册了');
            }else {
                return show(1,'用户名可用!');
            }
        }else {
            $data['name'] = hc_filter($data['users']);
            $data['users'] = hc_filter($data['users']);
            $data['password'] = hc_filter($data['password']);
            $data['hits'] = 1;

            $res = model('User')->allowField(true)->save($data);
            $userid = model('User')->getLastInsID();
            $user = model('User')->getUserInfoById($userid);
            $gameServer = model('GameServer')->getRecServerFindByGid($data['gid']);
            if($res) {
                session('user',$user,'index');
                return show(1,'注册成功',$gameServer['id']);
            }else {
                return show(0,'注册失败');
            }
        }


    }

}
