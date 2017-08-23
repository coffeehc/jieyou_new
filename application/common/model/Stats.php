<?php
namespace app\common\model;
use think\Model;

class Stats extends Model {

    public function getStatsInfo($data=[]) {
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order)->select();
        return $res;
    }

    public function getStatsCount($data=[]) {
        $res = $this->where($data)->count();
        return $res;
    }
}
