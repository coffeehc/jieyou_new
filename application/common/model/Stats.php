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

    /**
     * 获取柱状图信息
     * @return [type] [description]
     */
    public function getZhuztInfo() {
        $res = $this->query("select gid,count(1) zongshu,sum(case when register=1 then 1 else 0 end) zhuceshu from jy_stats GROUP BY gid");
        return $res;
    }
}
