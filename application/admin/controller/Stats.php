<?php
namespace app\admin\controller;
use think\Controller;

class Stats extends BaseController {
    private $_db;
    public function _initialize() {
        $this->_db = model('Stats');
    }

    /**
     * 统计列表
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['start_time']) < strtotime($data['end_time'])) {
            $sdata['create_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])]
            ];
        }
        if(!empty($data['gid'])) {
            $sdata['gid'] = ['like','%'.$data['gid'].'%'];
        }
        $stats = $this->_db->getStatsInfo($sdata);
        $count = $this->_db->getStatsCount($sdata);
        return $this->fetch('',[
            'stats' => $stats,
            'count' => $count,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            'gid' => !empty($data['gid']) ? $data['gid'] : '',
        ]);
    }

    /**
     * 统计 柱状图
     * @return [type] [description]
     */
    public function zhuzt() {
        $zhuztData = $this->_db->getZhuztInfo();
        $zhuztInfo = [];
        foreach ($zhuztData as $key => $value) {
            $zhuztInfo['categories'][] = getGameNameByGid($value['gid']);
            $zhuztInfo['zongshu'][] = $value['zongshu'];
            $zhuztInfo['zhuceshu'][] = intval($value['zhuceshu']);
        }
        // 把数组转成 JSON 格式 传给页面
        $data = json_encode($zhuztInfo);
        return $this->fetch('',[
            'data' => $data,
        ]);
    }

    /**
     * 统计 折线图
     * @return [type] [description]
     */
    public function zhext() {
        $zhextData = $this->_db->getZhextInfo();
        $zhextInfo = [];
        foreach ($zhextData as $key => $value) {
            $zhextInfo['time'][] = $value['time1'];
            $zhextInfo['gcd_cli'][] = $value['gcd_cli'];
            $zhextInfo['gcd_reg'][] = $value['gcd_reg'];
        }
        $data = json_encode($zhextInfo);
        return $this->fetch('',[
            'data' => $data,
        ]);
    }
}
