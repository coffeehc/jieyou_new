<?php
namespace app\api\controller;
use think\Controller;

class Gift extends Controller {

    /**
     * 礼包接口
     * @return [type] [description]
     */
    public function index() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $user = session('user','','index');
        if(!$user) {
            return show(0,'你还没有登录，请先登录:)');
        }
        $gsid = input('post.gsid'); // 游戏服务器ID
        $flag = true;
        // 如果数据库里面有对应的礼包卡号，则直接返回
        $haveGift = model('UserGift')->getGiftByUid($user['id'],$gsid);
        if($haveGift) {
            $flag = false;
            return show(1,$haveGift['giftid']);
        }

        // 如果没有，就请求借口，生成礼包卡号
        $serverInfo = model('GameServer')->getGameServerByid($gsid);  // 服务器信息
        // 判断服务器是否存在
        if(!$serverInfo) {
            return show(0,'礼包获取失败');
        }

        $userInfo = model('User')->getUserInfoById($user['id']);

        // 构造API信息
        $agent_id = "comecrazy";
        $game_id = $serverInfo['gid'];
        $serverNo = $serverInfo['sid'];
        $uid = $userInfo['users'];
        $time = time();
        $login_key = "a4058c1ae6a87db3";
        $sign = md5($agent_id.$game_id.$serverNo.$uid.$time.$login_key);
        $va_url = 'http://www.ufojoy.com/auth/gift.phtml';
        $post_fields = "agent_id={$agent_id}&game_id={$game_id}&serverNo={$serverNo}&uid={$uid}&time={$time}&sign={$sign}";
        $va_url = $va_url."?".$post_fields;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $va_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //设置结果保存在变量中，还是输出，默认为0（输出）
        curl_setopt($curl, CURLOPT_HEADER, 0);

        $response = curl_exec($curl);
        curl_close($curl);




        if(strstr($response,'Error')) {
            return show(0,'礼包获取失败');
        }else {
            // 存入数据库  如果 $flag 为 true 做 insert 操作 如果  为false 做 更新操作
            if($flag) {
                model('UserGift')->save(['gsid'=>$gsid,'uid'=>$userInfo['users'],'giftid'=>$response]);
            }else {
                model('UserGift')->where(['id'=>$haveGift['id']])->update(['giftid'=>$response]);
            }
            return show(1,$response);
        }
    }
}
