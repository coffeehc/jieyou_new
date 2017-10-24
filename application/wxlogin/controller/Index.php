<?php
namespace app\wxlogin\controller;

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
            'app_key' => 'xxxx'
        ];
    }

    /**
     * 信息返回页面
     * @return function [description]
     */
    public function callback() {

    }
}
