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

    /**
     * 统计列表 带分页
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getStatsInfoForPaginate($data=[]) {
        $res = $this->where($data)->order('id desc')->paginate();
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
        $res = $this->query("SELECT
                                `gid`,count(1) zongshu,sum(CASE WHEN `register`=1 THEN 1 ELSE 0 END) zhuceshu
                            FROM
                                `jy_stats`
                            GROUP BY
                                `gid`");
        return $res;
    }

    /**
     * 获取折线图的信息
     * @return [type] [description]
     */
    public function getZhextInfo() {
        $res = $this->query("SELECT
                            	from_unixtime(`create_time`, '%Y-%m-%d %H:00') time1,
                            	(
                            		SELECT
                            			count(id)
                            		FROM
                            			`jy_stats`
                            		WHERE
                            			`gid` = 'gcd'
                            		AND `create_time`  BETWEEN UNIX_TIMESTAMP(time1) AND UNIX_TIMESTAMP(time1)+60*60
                            	) gcd_cli,
                            	(
                            		SELECT
                            			count(id)
                            		FROM
                            			`jy_stats`
                            		WHERE
                            			`gid` = 'gcd'
                            		AND `register` = 1
                            		AND `create_time`  BETWEEN UNIX_TIMESTAMP(time1) AND UNIX_TIMESTAMP(time1)+60*60
                            	) gcd_reg
                            FROM
                            	`jy_stats`
                            GROUP BY
                                time1
                            ORDER BY
                            	`create_time` ASC ");
        return $res;
    }
}
