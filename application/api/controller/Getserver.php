<?php

namespace app\api\controller;

use think\Controller;

/**
 * 获取服务器
 */
class Getserver extends Controller {

    public function index() {
        $data = input('post.');
        try{
            $res = model('GameServer')->getServerInfoByGidSid(intval($data['sid']),$data['gid']);
            if($res) {
                return show(1,$res->id);
            }else {
                return show(0,'服务器不存在！');
            }
        }catch(\Exception $e) {
            return show(0,$e->getMessage());
        }
    }
}