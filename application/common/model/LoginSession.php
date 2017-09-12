<?php
namespace app\common\model;
use think\Model;

class LoginSession extends Model {
    public function getLoginSessionInfoByUser($user) {
        $res = $this->field(true)->where("user = '$user'")->find();
        return $res;
    }

    public function getLoginSessionCountByUser($user) {
        $res = $this->field(true)->where("user = '$user'")->count();
        return $res;
    }
}
