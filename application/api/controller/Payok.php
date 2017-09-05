<?php
namespace app\api\controller;
use think\Controller;

class Payok extends Controller {

    public function index() {
        $data = input('param.');

        if(empty($data['oid'])) {
            if(empty($data['OrderID'])) {
                return $this->error('订单号为空');
            }
            $orderInfo = model('UserPay')->getOrderInfoByOid($data['OrderID']);
            if(!$orderInfo) {
                return $this->error('没有相应的充值记录');
            }else {
                model('UserPay')->where("oid = ".$data['OrderID'])->update(['qx'=>1]);
            }
        }else {
            $orderInfo = model('UserPay')->field(true)->where("oid = ".$data['oid']." and uid = ".$data['uid']." and money = ".$data['money'])->find();

            if(!$orderInfo) {
                return $this->error('没有相应的充值记录');
            }else {
                model('UserPay')->where('oid = '.$data['oid'])->update(['qx'=>1]);
                return $this->success('恭喜您，成功充值'.$data['money'].'元 \\n 感谢您的支持!','index/index');
            }

        }
    }
}
