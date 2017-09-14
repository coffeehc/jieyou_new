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

    /**
     * 用户列表 带分页
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getUserInfoForPaginate($data=[]) {
        $res = $this->where($data)->order('id desc')->paginate();
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

    /**
     * 根据推荐人获取用户信息
     * @return [type] [description]
     */
    public function getCpsUserInfoByUid($id) {
        $res = $this->field(true)->where('tjrid='.$id)->order('id desc')->paginate(10);
        return $res;
    }

    /**
     * 根据用户ID 获取用户信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getUserInfoById($id) {
        $res = $this->field(true)->find($id);
        return $res;
    }

    /**
     * 通过 users  获取用户信息
     * @param  [type] $users [description]
     * @return [type]        [description]
     */
    public function getUserInfoByUsers($users) {
        $res = $this->field(true)->where("users = '$users'")->find();
        return $res;
    }
}
