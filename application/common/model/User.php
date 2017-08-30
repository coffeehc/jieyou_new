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

    public function getUserInfoForCps($data=[]) {
        $res = $this->where($data)->paginate(10);
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

    /**
     * 玩家数量
     * @return [type] [description]
     */
    public function getPlayerRegCount() {
        $res = $this->count();
        return $res;
    }

    public function getUserRand() {
        $res = $this
                ->field('id,name,pic')
                ->where("pic <> ('')")
                ->order('rand()')
                ->limit(16)
                ->select();
        return $res;
    }

    /**
     * 通过用户名获取用户
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public function getUserByUsername($username) {
        $res = $this->field(true)->where('users="'.$username.'"')->find();
        return $res;
    }
}
