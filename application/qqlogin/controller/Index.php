<?php
namespace app\qqlogin\controller;

use anerg\OAuth2\OAuth;

/**
 * QQ第三方登录
 */
class Index {
    /**
     * 跳转至登录页面
     * @return [type] [description]
     */
    public function index() {
        $config = [
            'app_key' => '101436262',
            'app_secret' => '5346de702f8948668b98feadb9b71a0e',
            'scope' => 'get_user_info',
            'callback' => [
                'default' => 'http://175jy.com/qqlogin/index/callback',
            ]
        ];
        session('last_url',$_SERVER['HTTP_REFERER'],'index');
        $Oauth = OAuth::getInstance($config ,'qq');
        return redirect($Oauth->getAuthorizeUrl());
    }

    /**
     * 信息返回页面
     * @return function [description]
     */
    public function callback() {
        $config = [
            'app_key' => '101436262',
            'app_secret' => '5346de702f8948668b98feadb9b71a0e',
            'scope' => 'get_user_info',
            'callback' => [
                'default' => 'http://175jy.com/qqlogin/index/callback',
            ]
        ];
        $OAuth    = OAuth::getInstance($config, 'qq');
        $OAuth->getAccessToken();

        $jump_str = '';     // 做JS跳转的字符串
        $userInfo = $OAuth->userinfo();
        $insertData['openid'] = $userInfo['openid'] ;
        $user = model('User')->getUserInfoByOpenid($insertData['openid']);  // 通过openid获取用户信息
        if(!$user) {
            // add
            $insertData['name'] = hc_filter($userInfo['nick']);
            $insertData['users'] = hc_filter($userInfo['nick']);
            $has_user = model('User')->getUserInfoByUsers($insertData);
            if($has_user) {  // 判断用户名是否被注册
                $insertData['users'] = hc_filter($userInfo['nick']).rand(100,999);
            }
            $insertData['sex'] = $userInfo['gender'];
			$insertData['pic'] = $userInfo['avatar'];
            $insertData['hits'] = 1;

            $res = model('User')->save($insertData);
            $userid = model('User')->getLastInsID();
            $loginUser = model('User')->getUserInfoById($userid);

            // 登录成功 同步到论坛
            $uc_email = time().'@mail.com';
            $uc_uid = uc_user_register($loginUser['users'],$loginUser['openid'],$uc_email);  // 第三方登录同步到论坛 让openid作为密码
            if($uc_uid > 0) {  // 如果注册成功
                list($uid,$username,$password,$email) = uc_user_login($loginUser['users'],$loginUser['openid']);
                $jump_str .= uc_user_synlogin($uid);
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
