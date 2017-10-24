<?php
namespace app\qqlogin\controller;

use anerg\OAuth2\OAuth;

/**
 * 微信扫码第三方登录
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

        $userInfo = $OAuth->userinfo();
        $insertData['openid'] = $userInfo['openid'] ;
        $user = model('User')->getUserInfoByOpenid($insertData['openid']);  // 通过openid获取用户信息
        if(!$user) {
            // add
            $insertData['name'] = hc_filter($userInfo['nick']);
            $insertData['users'] = hc_filter($userInfo['nick']);
            $insertData['sex'] = $userInfo['gender'];
			$insertData['pic'] = $userInfo['avatar'];
            $isUser = model('User')->getUserInfoByUsers($userInfo['nick']); // 判断这个users 是否被注册
            if($isUser) {
                $insertData['users'] = $insertData['users'].rand(1000,9999);
            }
            $insertData['hits'] = 1;

            $res = model('User')->save($insertData);
            $userid = model('User')->getLastInsID();
            $loginUser = model('User')->getUserInfoById($userid);
            session('user',$loginUser,'index');
            return redirect('/');
        }else {
            // update
            $updateData = [];
            $updateData['name'] = $userInfo['nick'];
            $updateData['update_time'] = time();
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update($updateData);
            return redirect('/');
        }
    }
}
