<?php
namespace app\common\model;
use think\Model;

class Manager extends Model {

    /**
     * 获取管理员信息
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getManagerInfo($data=[]) {
        $order = [
            'id' => 'desc',
        ];
        $res = $this
                ->where($data)
                ->order($order)
                ->select();
        return $res;
    }

    /**
     * 获取管理员数量
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getManagerCount($data=[]) {
        $res = $this->where($data)->count();
        return $res;
    }
}
