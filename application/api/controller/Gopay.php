<?php
namespace app\api\controller;
use think\Controller;

class Gopay extends Controller {

    public function index() {
        $gid = session('gameserverid','','index');
        if(isset($gid)) {
            // $surl = "Location: http://".$_SERVER['SERVER_NAME']."/my/pay".$gid.".html";
	        return redirect('index/Pay/index',['id'=>$gid]);
        }else {
            $uid = input('param.uid');
            $userInfo = model('User')->getUserByUsername($uid);
            $gid = model('UserServer')->getGsidByUserid($userInfo['id']);
            // $res = model('LoginSession')->getLoginSessionInfoByUser($uid);
            // if($res) {
            //     session_destroy();
            //     session_id($res['sessionid']);
            //     session_start();
            // }
            return redirect('index/Pay/index',['id'=>$gid]);
        }
    }
}
