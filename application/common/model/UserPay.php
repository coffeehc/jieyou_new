<?php
namespace app\common\model;
use think\Model;

class UserPay extends Model {

    public function getUserPayByUid($id) {
        $res = $this->where('uid',$id)->select();
        return $res;
    }
    public function getUserPayCount($id) {
        $res = $this->where('uid',$id)->count();
        return $res;
    }

    /**
     * 支付成功金额
     * @return [type] [description]
     */
    public function getPaySuccessMoney() {
        $res = $this->field('sum(money) as money')->where('qx = 1')->find();
        return $res['money'];
    }

    public function getPayErrorMoney() {
        $res = $this->field('sum(money) as money')->where('qx <> 1')->find();
        return $res['money'];
    }
}
