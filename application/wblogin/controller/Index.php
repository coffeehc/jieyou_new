<?php
namespace app\wblogin\controller;
use think\Controller;
use anerg\OAuth2\OAuth;

/**
 * 微博第三方登录
 */
class Index extends Controller{
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

        $userInfo = $OAuth->userinfo();
        $insertData['openid'] = $userInfo['openid'] ;
        $user = model('User')->getUserInfoByOpenid($insertData['openid']);  // 通过openid获取用户信息
        if(!$user) {
            // add
            $insertData['name'] = hc_filter($userInfo['nick']);
            $insertData['users'] = hc_filter($userInfo['nick']);
            $insertData['sex'] = $userInfo['gender'];
			$insertData['pic'] = $userInfo['avatar'];
            $isUser = model('User')->getUserInfoByUsers($userInfo['nickname']); // 判断这个users 是否被注册
            if($isUser) {
                $insertData['users'] = $insertData['users'].rand(1000,9999);
            }
            $insertData['hits'] = 1;

            $res = model('User')->save($insertData);
            $userid = model('User')->getLastInsID();
            $loginUser = model('User')->getUserInfoById($userid);
            session('user',$loginUser,'index');
            $last_url = session('last_url','','index');
            session('last_url',null);
            $url = !$last_url ? '/' : $last_url;
            return redirect($url);
        }else {
            // update
            $updateData = [];
            $updateData['name'] = $userInfo['nickname'];
            $updateData['update_time'] = time();
            session('user',$user,'index');
            model('User')->where('id',$user['id'])->setInc('hits');
            model('User')->where('id',$user['id'])->update($updateData);
            $last_url = session('last_url','','index');
            session('last_url',null);
            $url = !$last_url ? '/' : $last_url;
            return redirect($url);
        }
    }
}
