<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  玩家管理
 */
class User extends BaseController {

    private $_db;
    public function _initialize() {
        $this->_db = model('User');
    }
    /**
     *  玩家列表
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['start_time']) < strtotime($data['end_time'])) {
            $sdata['creat_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['users'])) {
            $sdata['users'] = ['like','%'.$data['users'].'%'];
        }

        $users = $this->_db->getUserInfo($sdata);
        $count = $this->_db->getUserCount($sdata);
        return $this->fetch('',[
            'users' => $users,
            'count' => $count,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            'name' => !empty($data['users']) ? $data['users'] : ''
        ]);
    }

    /**
     * 充值记录
     */
    public function payRecord($id=0) {
        $payRecords = model('UserPay')->getUserPayByUid($id);
        $count = model('UserPay')->getUserPayCount($id);
        $user = model('User')->getUserByID($id);
        return $this->fetch('',[
            'payRecords' => $payRecords,
            'count' => $count,
            'user' => $user,
        ]);
    }

    /**
     * 给玩家充值
     * @return [type] [description]
     */
    public function recharge() {
        if(request()->isPost()) {
            $user = input('post.users');
            $res = model('User')->getUserByUsername($user);
            if($res) {
                return show(1,'有这个人');
            }else {
                return show(0,'没得这个人');
            }
        }else {
            $games = model('Game')->getGameInfo();
            return $this->fetch('',[
                'games' => $games,
            ]);
        }
    }

    /**
     * 根据游戏GID 放回他的服务器数据
     * @return [type] [description]
     */
    public function getGameServer() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        $serverInfo = model("GameServer")->getGameServerByGid($data['gid']);
        if($serverInfo) {
            return show(1,'有数据',$serverInfo);
        }else {
            return show(0,'没有相关服务器');
        }
    }

    /**
     * 支付接口
     * @return [type] [description]
     */
    public function pay() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        if($data['forms'] == 'pay') {
            $gameServerInfo = model('GameServer')->getGameServerByid($data['sid']);
            if(!$gameServerInfo) {
                return $this->error('系统错误');
            }

            // 获取游戏对应的代理商平台接口信息
            $ptInfo = model('Apikey')->getPtInfoById($gameServerInfo['ptid']);
            if(!$ptInfo) {
                return $this->error('系统错误');
            }

            // 获取支付方式 信息
            $payInfo = model('Payfs')->getPayfsInfoById($data['bank']);

            // 获取用户的信息
            $user = model('User')->getUserInfoByUsers($data['user']);
            // 对接充值接口
            $key = $ptInfo['paykey'];
            if($gameServerInfo['ptid'] == 2) {
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

                $va_url = 'http://www.ufojoy.com/auth/payto.phtml';
                // post 提交的数据串
                $post_fields = "agent_id={$agent_id}&game_id={$game_id}&serverNo={$serverNo}&uid={$uid}&OrderID={$OrderID}&amount={$amount}&paytype={$paytype}&rel={$rel}&time={$time}&charname={$charname}&sign={$sign}";

                $curl = curl_init(); //初始化一个cURL会话，必有
    			//curl_setopt()函数用于设置 curl 的参数，其功能非常强大，具体看手册
    			curl_setopt($curl, CURLOPT_URL, $va_url);      //设置验证登陆的 url 链接
    			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0); //设置结果保存在变量中，还是输出，默认为0（输出）
    			curl_setopt($curl, CURLOPT_POST, 1);           //模拟post提交
    			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields); //设置post串
    			$result = curl_exec($curl);  //执行此cURL会话，必有
                // 检查是否有错
                if(curl_errno($curl)) {
                    return $this->error(curl_error($curl));
                }

                curl_close($curl);  // 关闭会话

                die('');
            }
        }
    }
}
