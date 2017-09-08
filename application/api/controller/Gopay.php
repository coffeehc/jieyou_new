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
            $uid = input('param.');
            $res = model('LoginSession')->getLoginSessionInfoByUser($uid);
            if($res) {
                session_destroy();
                session_id($res['sessionid']);
                session_start();
            }
            return redirect('index/Pay/index',['id'=>$gid]);
        }
    }
}
