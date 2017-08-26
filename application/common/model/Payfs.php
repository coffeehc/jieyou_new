<?php
namespace app\common\model;
use think\Model;

class Payfs extends Model {

    public function getPayfsInfo() {
        $order = [
            'id' => 'ASC',
        ];
        $res = $this->order($order)->select();
        return $res;
    }
}
