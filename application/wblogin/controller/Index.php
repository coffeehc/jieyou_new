<?php
namespace app\wblogin\controller;

use anerg\OAuth2\OAuth;

/**
 * weibo第三方登录
 */
class Index {
    /**
     * 跳转至登录页面
     * @return [type] [description]
     */
    public function index() {
        $config = [
            'app_key' => '1913330084',
            'app_secret' => 'cd4480ab88498218aa429cc1e8bb9f8f',
            'scope' => 'get_user_info',
            'callback' => [
                'default' => 'http://175jy.com/wblogin/index/callback',
            ]
        ];
        session('last_url',$_SERVER['HTTP_REFERER'],'index');
        $Oauth = OAuth::getInstance($config ,'weibo');
        return redirect($Oauth->getAuthorizeUrl());
    }

    /**
     * 信息返回页面
     * @return function [description]
     */
    public function callback() {
        $config = [
            'app_key' => '1913330084',
            'app_secret' => 'cd4480ab88498218aa429cc1e8bb9f8f',
            'scope' => 'get_user_info',
            'callback' => [
                'default' => 'http://175jy.com/wblogin/index/callback',
            ]
        ];
        $OAuth    = OAuth::getInstance($config, 'weibo');
        $OAuth->getAccessToken();

        $jump_str = '';     // 做JS跳转的字符串
        $userInfo = $OAuth->userinfo();
        $insertData['openid'] = $userInfo['openid'] ;
        $user = model('User')->getUserInfoByOpenid($insertData['openid']);  // 通过openid获取用户信息
        if(!$user) {
            // add
            $insertData['name'] = hc_filter($userInfo['nick']);
            $insertData['users'] = time().rand(1000,9999);   // 第三方登录账号 统一时间戳加 4 位随机数
            $insertData['sex'] = $userInfo['gender'];
			$insertData['pic'] = $userInfo['avatar'];
            $insertData['hits'] = 1;

            $res = model('User')->save($insertData);
            $userid = model('User')->getLastInsID();
            $loginUser = model('User')->getUserInfoById($userid);

            // 登录成功 同步到论坛
            $uc_email = $loginUser['users'].'@mail.com';
            $uc_uid = uc_user_register($loginUser['users'],$loginUser['openid'],$uc_email);  // 第三方登录同步到论坛 让openid作为密码

            if($uc_uid > 0) {
                list($uid,$username,$password,$email) = uc_user_login($loginUser['users'],$loginUser['openid']);
            }

            if($uid > 0) {
                $jump_str .= uc_user_synlogin($uid);   // 同步完成输出一次 JS 脚本  让论坛登录
            }

            session('user',$loginUser,'index');
            $last_url = session('last_url','','index');
            session('last_url',null);
            $url = !$last_url ? '/' : $last_url;
            $jump_str .= "<script>window.location.href='$url';</script>";
            echo $jump_str;
        }else {
            // update
            $updateData = [];
            $updateData['name'] = $userInfo['nick'];
            $updateData['update_time'] = time();

            list($uid,$username,$password,$email) = uc_user_login($user['users'],$user['openid']);
            if($uid > 0) {
                $jump_str .= uc_user_synlogin($uid);   // 同步完成输出一次 JS 脚本  让论坛登录
            }

            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update($updateData);
            $last_url = session('last_url','','index');
            session('last_url',null);
            $url = !$last_url ? '/' : $last_url;
            $jump_str .= "<script>window.location.href='$url';</script>";
            echo $jump_str;
        }
    }
}
