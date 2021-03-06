<?php
namespace app\index\controller;
use think\Controller;

class Pay extends BaseController {

    /**
     * 充值页面
     * @return [type] [description]
     */
    public function index() {
        $serverId = input('param.id');
        $serverInfo = $gsidArr = [];
        $serverInfo['game'] = '';
        $serverInfo['name'] = '';
        $serverInfo['id'] = '';
        if($serverId) {
            $serverInfo = model('GameServer')->getGameServerByid($serverId);
        }
        // 获取服务器信息
        $user = $this->getLoginUser();
        if($user) {
            // 最近玩过的游戏
            $gsidArr = model('UserServer')->getGidByUid($user['id']);
        }


        // $payWays = model('Payfs')->getPayfsInfo();
        // 网银充值
        $wy = model('Payfs')->getPayfsInfo(['tid'=>4]);

        // 卡类充值
        $card = model('Payfs')->getPayfsInfo(['tid'=>5]);

        // 没有登录状态下 获取不到最近玩过的游戏
        $lastPlayEmpty = '<p>只能查看登录账号的游戏和区服记录:)</p>';
        return $this->fetch('',[
            'serverInfo' => $serverInfo,
            'wy' => $wy,
            'card' => $card,
            'gsidArr' => $gsidArr,
            'lastPlayEmpty' => $lastPlayEmpty,
            'game' => !empty($serverInfo['game']) ? $serverInfo['game'] : '选择游戏',
            'name' => !empty($serverInfo['name']) ? $serverInfo['name'] : '选择区服',
            // 'payWays' => $payWays,
        ]);
    }

    /**
     * 选择游戏 获取服务器信息
     * @return [type] [description]
     */
    public function choosedGame() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }

        $user = $this->getLoginUser();

        $data = input('post.');
        $lastPlay = [];
        $arrs = [];
        try {
            $servers = model("GameServer")->getServerByGid($data['gid']);
            if($user) {
                $lastPlay = model("UserServer")->getLastPlayedByUidAndGid($user['id'],$data['gid']);
            }
            if($servers) {
                $arr = array_chunk($servers,100);
                $arrs['allservers'] = $arr;
                $arrs['myservers'] = $lastPlay;
                return show(1,'有服务器',$arrs);
            }else {
                return show(0,'没有服务器信息');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * 搜索服务器
     * @return [type] [description]
     */
    public function searchServer() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        if(!is_numeric($data['sid'])) {
            return $this->error('服务器编号不合法');
        }
        try {
            $res = model('GameServer')->getServerInfoByGidSid($data['sid'],$data['gid']);
            if($res) {
                return show(1,'有服务器信息',$res);
            }else {
                return show(0,'没有相关服务器信息');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * 提交充值的时候检查用户账号
     * @return [type] [description]
     */
    public function checkUser() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input("post.");
        $data['user'] = hc_filter($data['user']);
        try {
            $user = model("User")->getUserInfoByUsers($data['user']);
            if($user) {
                return show(1,'有相关信息');
            }else {
                return show(0,'没有相关信息');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }

    }

    /**
     * 确认支付
     * @return [type] [description]
     */
    public function ispay() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        // 如果提交了充值信息
        if($data['forms'] == 'pay') {
            // 获取充值的游戏信息
            $gameServerInfo = model('GameServer')->getGameServerByid($data['sid']);
            if(!$gameServerInfo) {
                return $this->error('系统错误');
            }

            // 获取游戏对应的代理商平台接口信息
            $ptInfo = model('Apikey')->getPtInfoById($gameServerInfo['ptid']);
            if(!$ptInfo) {
                return $this->error('系统错误');
            }
            // 获取登录的用户信息
            // $user = session('user','','index');
            // if(!$user) {
            //     return $this->error('登录超时，请重新登录');
            // }
            // 用户相关信息
            $user = model("User")->getUserInfoByUsers($data['users']);


            // 获取支付方式 信息
            $payInfo = model('Payfs')->getPayfsInfoById($data['bank']);

            $key = $ptInfo['paykey'];
            if($gameServerInfo['ptid'] == 1) {
                $oid = date('Ymdhis',time()).rand(1000,9999);
                $uid = $user['id'];
                $gid = $gameServerInfo['gid'];
                $sid = $gameServerInfo['sid'];
                $money = intval($data['money']);
                $mid = $ptInfo['pid'];
                $pid = $payInfo['type'];
                $bank = $payInfo['pay'];
                $sign = md5($oid.$uid.$gid.$sid.$mid.$money.$pid.$bank.$key);
                // 添加一条数据到数据库
                $insertData = [
                    'oid' => $oid,
                    'game' => $gameServerInfo['game'],
                    'money' => $money,
                    'qx' => 0,
                    'uid' => $user['id'],
                    'uidname' => $user['name'],
                    'ptid' => $gameServerInfo['ptid'],
                    'tid' => $payInfo['id'],
                    'bank' => $payInfo['name'],
                ];
                model('UserPay')->save($insertData);
                $url = "http://yylm.265g.com/?tp=recharge&uid=".$uid."&gid=".$gid."&sid=".$sid."&mid=".$mid."&oid=".$oid."&money=".$money."&pid=".$pid."&bank=".$bank."&sign=".$sign;
                echo $key."<br>";
        		//die($url);
        		header('location:'.$url);
            }else if($gameServerInfo['ptid'] == 2) {  // 星蝶游戏平台
                $agent_id = $ptInfo['pid'];
                $game_id = $gameServerInfo['gid'];
                $serverNo = $gameServerInfo['sid'];
                $uid = $user['users'];
                $OrderID = date('Ymdhis',time()).rand(1000,9999);
                $amount = intval(trim($data['money']));
                $paytype = $payInfo['pay'];
                $rel = urlencode("http://".$_SERVER['SERVER_NAME']);  // 星蝶充值参数充值成功跳转地址
                $time = time();
                $charname = ''; // 暂时不知道有什么意思
                $sign = md5($agent_id.$game_id.$serverNo.$uid.$OrderID.$amount.$paytype.$time.$key);
                $insertData = [
                    'oid' => $OrderID,
                    'game' => $gameServerInfo['game'],
                    'money' => $amount,
                    'qx' => 0,
                    'uid' => $user['id'],
                    'uidname' => $user['name'],
                    'ptid' => $gameServerInfo['ptid'],
                    'tid' => $payInfo['id'],
                    'bank' => $paytype,
                ];
                model('UserPay')->save($insertData);
            }else if($gameServerInfo['ptid'] == 4) {  // 57ac平台
                // todo
            }
        }
        return $this->fetch('',[
            'agent_id' => $agent_id,
            'game_id' => $game_id,
            'serverNo' => $serverNo,
            'uid' => $uid,
            'OrderID' => $OrderID,
            'amount' => $amount,
            'paytype' => $paytype,
            'rel' => $rel,
            'time' => $time,
            'charname' => $charname,
            'sign' => $sign,
        ]);
    }
}
