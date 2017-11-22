<?php
namespace app\index\controller;
use think\Controller;

class Game extends BaseController {

    public function index() {
        if(request()->isPost()) {
            $data = input('post.');
            if($data['qx'] == 1) {  // 新账号注册
                if(empty($data['users1'])) {
                    return show(0,'账号不能为空');
                }
                if(empty($data['password'])) {
                    return show(0,'密码不能为空');
                }
                if(empty($data['password1']) || $data['password'] != $data['password1']) {
                    return show(0,'两次密码不一致');
                }
                if(model('User')->getUserByUsername($data['users1'])) {
                    return show(0,'用户名已存在');
                }
                $data['users'] = hc_filter($data['users1']);
                $data['name'] = hc_filter($data['users1']);
                $data['hits'] = 1;
                try {
                    $res = model('User')->allowField(true)->save($data);
                    $userid = model('User')->getLastInsID();
                    $user = model('User')->getUserInfoById($userid);
                    if($res) {
                        // 门户网站注册同时注册到论坛

                        $uc_email = $data['users'].'@mail.com';

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

            }else if($data['qx'] == 2) {  // 老账号登录
                if(empty($data['users2'])) {
                    return show(0,'账号不能为空');
                }
                if(empty($data['password'])) {
                    return show(0,'密码不能为空');
                }
                $data['users'] = $data['users2'];
                $user = model('User')->getUserByUsername($data['users']);
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
                    session('user',$user,'index');
                    model('User')->allowField(true)->where('id',$user['id'])->setInc('hits');
                    model('User')->allowField(true)->where('id',$user['id'])->update(['update_time'=>time()]);
                    return show(1,$user['users'].'欢迎您！');
                }else {
                    return show(0,'用户名或密码错误');
                }
            }
        }else {
            // 登录的用户信息
            $user = $this->getLoginUser();
            $serverId = input('param.id');
            $client = input('param.client');
            $url = '';
            // 是否有传入游戏编号
            if(empty($serverId)) {
                // 如果没有服务器ID 则获取最近开服的服务器信息
                $serverInfo = model('GameServer')->field(true)->where('create_time < '.time())->order('id desc')->find();
            }else {
                // 如果有服务器编号 则通过游戏编号获取服务器信息
                $serverInfo = model('GameServer')->field(true)->where("id = $serverId")->find();
            }

            // 把服务器ID 存入 SESSION  方便充值的时候提取服务器ID
            session('gameserverid',$serverInfo['id'],'index');
            // 根据游戏gid 获取游戏信息
            $gameGid = $serverInfo['gid'];
            $gameInfo = model('Game')->field(true)->where("gid = '$gameGid'")->find();
            if($user && $user['id']) {
                $userInfo = model('User')->field(true)->where('id = '.$user['id'])->find();
                // 如果游戏开区时间大于当前时间 则提示游戏还没有开区
                $year = date('Y',time());
                if(strtotime($year.'-'.$serverInfo['create_time']) > time()) {
                    return $this->error('游戏还没有开启');
                }else {
                    // 如果游戏已经开区 则添加一条数据到数据库
                    $isUserServer = model('UserServer')->field(true)->where("gsid = ".$serverInfo['id']." and userid = ".$userInfo['id'])->find();
                    if($isUserServer) {
                        model('UserServer')->where("userid = ".$userInfo['id']." and gsid = ".$serverInfo['id'])->update(['update_time'=>time()]);
                    }else {
                        $userServer = [
                            'name' => $serverInfo['game'].$serverInfo['name'],
                            'gid' => $serverInfo['gid'],
                            'gsid' => $serverInfo['id'],
                            'userid' => $userInfo['id']
                        ];
                        model('UserServer')->save($userServer);
                    }
                }

                // 对接游戏借口
                $apijk = model('Apikey')->field(true)->where('id = '.$serverInfo['ptid'])->find();
                if($serverInfo['ptid'] == 2) {  // 星蝶游戏平台
                    // 构造接口数据
                    $uid = trim($userInfo['id']);
                    $uid2 = $userInfo['users'];
                    $gid = $serverInfo['gid'];
                    $sid = $serverInfo['sid'];
                    $dateline = time();
                    $mid = $apijk['pid'];
                    $pc = '0';
                    $fcm = '0';
                    $key = $apijk['apikey'];
                    $sign = strtolower(md5($mid.$gid.$sid.$uid2.$dateline.$key));
                    if($client && $client == 'pc') {
                        $url = "http://www.ufojoy.com/auth/go.phtml?agent_id=".$mid."&game_id=".$gid."&serverNo=".$sid."&uid=".$uid2."&time=".$dateline."&sign=".$sign."&client=pc";
                    }else {
                        $url = "http://www.ufojoy.com/auth/go.phtml?agent_id=".$mid."&game_id=".$gid."&serverNo=".$sid."&uid=".$uid2."&time=".$dateline."&sign=".$sign;
                    }
                   
                }elseif($serverInfo['ptid'] == 4) {  // 57ac 平台
                    // 构造接口数据
                    $pid = $apijk['pid'];  // 平台ID
                    $account = $userInfo['users'];  // 玩家账号
                    $gid = $serverInfo['gid'];    // 游戏ID
                    $sid = $serverInfo['sid'];    // 服务器编号
                    $fcm = 1;  // 防沉迷  先默认为 1
                    $time = time(); // 当前时间戳
                    $isclient = 0;  // 对接游戏有微端时微端登录则传 1，网页登录传0
                    $key = $apijk['apikey'];
                    $sign = md5($pid.$account.$gid.$sid.$time.$key);
                    $url = "http://www.57ac.com/api/GameLoginHandler.ashx?pid=".$pid."&account=".$account."&gid=".$gid."&sid=".$sid."&fcm=".$fcm."&time=".$time."&isclient=".$isclient."&sign=".$sign;
                }
            }
            return $this->fetch('',[
                'url' => $url,
                'game' => $gameInfo,
                'server' => $serverInfo,
            ]);
        }
    }
}
