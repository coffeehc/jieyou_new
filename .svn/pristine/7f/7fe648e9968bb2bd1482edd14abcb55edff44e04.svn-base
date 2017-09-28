<?php
namespace app\index\controller;
use think\Controller;

class Register extends BaseController {

    public function index() {
        $tjrid = $tjr = '';
        $data = input('param.');
        if($data) {
            if($data['tjrid'] && $data['tjrid'] != '') {
                $tjrInfo = model('User')->field('id,users')->where('id='.$data['tjrid'])->find();
            }else if($data['tjr'] && $data['tjr'] != '') {
                $tjrInfo = model('User')->field('id,users')->where('users='.$data['tjr'])->find();
            }
            $tjrid = $tjrInfo['id'];
            $tjr = $tjrInfo['users'];
        }
        return $this->fetch('',[
            'tjrid' => !empty($tjrid) ? $tjrid : '',
            'tjr' => !empty($tjr) ? $tjr : '',
        ]);
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
        if($data['name'] == '') {
            $data['name'] = hc_filter($data['users']);
        }
        $data['hits'] = 1;
        $data['users'] = hc_filter($data['users']);
        try {
            $res = model('User')->allowField(true)->save($data);
            $userid = model('User')->getLastInsID();
            $user = model('User')->getUserInfoById($userid);
            if($res) {
                session('user',$user,'index');
                $sid =session('sid','','index');
                if($sid != null) {
                    model('Stats')->where('id = '.$sid)->update(['register'=>1,'userid'=>$userid]);
                    session('sid',null);
                }
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
        $user = model('User')->getUserByUsername($data['users']);
        $lastplay = model("UserServer")->field(true)->where('userid='.$user['id'])->order('update_time desc')->limit(4)->select();
        $callBackArr['user'] = $user;
        $callBackArr['lastplay'] = $lastplay;
        if($user && $user['password'] == $data['password']) {
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update(['update_time'=>time()]);
            return show(1,$user['users'].'欢迎您！',$callBackArr);
        }else {
            return show(0,'用户名或密码错误');
        }
    }

    /**
     * 退出平台
     * @return [type] [description]
     */
    public function logout() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        if($data['target'] == 1) {
            session(null,'index');
            return show(1,'欢迎下次再来');
        }
    }
}
