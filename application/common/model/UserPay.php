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
}
