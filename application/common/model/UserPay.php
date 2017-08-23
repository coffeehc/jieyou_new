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

    /**
     * 通过ID 获取下线的充值记录
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getCpsPayInfo($id) {
        $res = $this->field('a.oid,a.game,a.update_time,a.money,a.qx,b.users')
                    ->alias('a')
                    ->join('jy_user b','a.uid = b.id')
                    ->where('b.tjrid='.$id)
                    ->select();
        return $res;
    }

    public function getCpsPayCount($id) {
        $res = $this->field('a.oid,a.game,a.update_time,a.money,a.qx,b.users')
                    ->alias('a')
                    ->join('jy_user b','a.uid = b.id')
                    ->where('b.tjrid='.$id)
                    ->count();
        return $res;
    }
}
