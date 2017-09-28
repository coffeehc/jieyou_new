<?php
namespace app\api\controller;
use think\Controller;

class Pay extends Controller {

    /**
     * 对接支付API
     * @return [type] [description]
     */
    public function index() {
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
            $user = session('user','','index');
            if(!$user) {
                return $this->error('登录超时，请重新登录');
            }

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
            }else if($gameServerInfo['ptid'] == 2) {
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
