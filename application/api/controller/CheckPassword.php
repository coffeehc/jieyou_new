<?php
namespace app\api\controller;
use think\Controller;

/**
 * 根据用户ID 检查用户输入密码是否正确
 */
class CheckPassword extends Controller {
    public function index() {
        $data = input('param.');
        if(!is_numeric($data['id'])) {
            return show(0,'ID不合法');
        }
        $userInfo = model('User')->get($data['id']);
        if($userInfo['password'] != $data['password']) {
            return '原密码输入错误';
        }else {
            return true;
        }
    }
}