<?php
namespace app\common\model;
use think\Model;

class Payfs extends Model {

    public function getPayfsInfo($data=[]) {
        $order = [
            'id' => 'ASC',
        ];
        $res = $this->where($data)->order($order)->select();
        return $res;
    }

    /**
     * 通过支付方式的ID 获取支付方式信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getPayfsInfoById($id) {
        $res = $this->field(true)->find($id);
        return $res;
    }
}
