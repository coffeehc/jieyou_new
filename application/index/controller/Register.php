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

                // 门户网站注册同时注册到论坛
                if($data['email'] == '') {
                    $uc_email = $data['users'].'@mail.com';
                }else {
                    $uc_email = $data['email'];
                }
                uc_user_register($data['users'],$data['password'],$uc_email);

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
        if(!$user) {
            return show(0,'该用户还没有注册，请先注册');
        }
        $lastplay = model("UserServer")->field(true)->where('userid='.$user['id'])->order('update_time desc')->limit(4)->select();
        $callBackArr['user'] = $user;
        $callBackArr['lastplay'] = $lastplay;



        if($user && $user['password'] == $data['password']) {
            // UC 同步到论坛操作
            $uc_user = uc_get_user($data['users']);  // 检查用户

            if($uc_user['0'] > 0) {
                $uc_uid = $uc_user['0'];            // 存在用户 记录用户ID
            }else {                                 // 不存在  注册用户
                if($user['email'] == '') {
                    $uc_mail = $data['users'].'@mail.com';   //  如果在门户网站的用户没有邮箱 则构造一个邮箱地址
                }else {
                    $uc_mail = $user['email'];
                }
                $uc_uid = uc_user_register($data['users'],$data['password'],$uc_mail);
            }

            if($uc_uid > 0) {
                list($uid,$username,$password,$email) = uc_user_login($data['users'],$data['password']);
            }

            if($uid > 0) {
                $callBackArr['uc_login']  = uc_user_synlogin($uid);
            }

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
