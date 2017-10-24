<?php
namespace app\qqlogin\controller;
use think\Controller;
use kuange\qqconnect\QC;

class Callback extends Controller
{
    public function qqAction()
    {
        $insertData = [];
        $qc = new QC();
        $qc->qq_callback();    // access_token
        $userInfo = $qc->get_user_info();   // 获取到QQ登录的用户信息
        $insertData['openid'] = $qc->get_openid();     // openid
        $user = model('User')->getUserInfoByOpenid($insertData['openid']);  // 通过openid获取用户信息
        if(!$user) {    // 注册
            // add
            $insertData['name'] = hc_filter($userInfo['nickname']);
            $insertData['users'] = hc_filter($userInfo['nickname']);
            $isUser = model('User')->getUserInfoByUsers($userInfo['nickname']); // 判断这个users 是否被注册
            if($isUser) {
                $insertData['users'] = $insertData['users'].rand(1000,9999);
            }
            $insertData['hits'] = 1;

            $res = model('User')->save($inserData);
            $userid = model('User')->getLastInsID();
            $loginUser = model('User')->getUserInfoById($userid);
            session('user',$loginUser,'index');
            return redirect('/');
        }else {   // 二次登录
            // update
            $updateData = [];
            $updateData['name'] = $userInfo['nickname'];
            $updateData['update_time'] = time();
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update($updateData);
            return redirect('/');
        }
    }
}
