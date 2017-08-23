<?php
namespace app\admin\controller;
use think\Controller;

class Stats extends Controller {
    private $_db;
    public function _initialize() {
        $this->_db = model('Stats');
    }

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
}
