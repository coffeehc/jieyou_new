<?php
namespace app\common\model;
use think\Model;

class UserGift extends Model {

    public function getGiftByUid($uid,$gsid) {
        $res = $this
                ->field('a.giftid')
                ->alias('a')
                ->join('jy_user b','a.uid = b.users')
                ->where("b.id = $uid AND a.gsid = $gsid")
                ->find();
        return $res;
    }
}
