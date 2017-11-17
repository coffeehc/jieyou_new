<?php
namespace app\api\controller;
use think\Controller;
use app\common\lib\Send;
use think\Cache;
/**
 * 发送短信API
 */
class Sendsms extends Controller {

    /**
     * 请求入口
     */
    public function index() {
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        $data = input('post.');
        $phone = $data['phone'];
        $code = rand(1000,9999);
        Cache::set($phone,$code,180);
        $isSend = $this->sendSms($phone,$code);
        if($isSend == 'true') {
            return show(1,'验证码发送成功');
        }else {
            return show(0,'系统繁忙请稍后再试');
        }
    }
    /**
     * 发送短信
     */
    public function sendSms($phone='',$code='') {
        $response = Send::sendSms(
            config('aliyun.signName'), // 短信签名
            config('aliyun.sms'), // 短信模板编号
            $phone, // 短信接收者
            Array(  // 短信模板中字段的值
                "code"=>$code,
            ),
            "123"   // 流水号,选填
        );
        if($response->Code == 'OK') {
            return 'true';
        }else {
            return 'false';
        }
    }

    /**
     * 检查验证码
     */
    public function checkCaptcha() {
        $data = input('param.');
        if($data['captcha'] != Cache::get($data['phone'])) {
            return '验证码输入错误';
        }else {
            return true;
        }
    }
}