<?php
namespace app\common\model;
use think\Model;

class User extends Model {

    public function getUserInfo($data=[]) {
        $order = [
            'id' => 'desc'
        ];
        $res = $this->where($data)->order($order)->select();
        return $res;
    }

    public function getUserCount($data=[]) {
        $res = $this->where($data)->count();
        return $res;
    }

    public function getUserById($id=0) {
        $res = $this->field('users')->find($id);
        return $res['users'];
    }
}
