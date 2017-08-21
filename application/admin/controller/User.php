<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  玩家管理
 */
class User extends BaseController {

    private $_db;
    public function _initialize() {
        $this->_db = model('User');
    }
    /**
     *  玩家列表
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['start_time']) < strtotime($data['end_time'])) {
            $sdata['creat_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['users'])) {
            $sdata['users'] = ['like','%'.$data['users'].'%'];
        }

        $users = $this->_db->getUserInfo($sdata);
        $count = $this->_db->getUserCount($sdata);
        return $this->fetch('',[
            'users' => $users,
            'count' => $count,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            'name' => !empty($data['users']) ? $data['users'] : ''
        ]);
    }

    /**
     * 充值记录
     */
    public function payRecord($id=0) {
        $payRecords = model('UserPay')->getUserPayByUid($id);
        $count = model('UserPay')->getUserPayCount($id);
        $user = model('User')->getUserByID($id);
        return $this->fetch('',[
            'payRecords' => $payRecords,
            'count' => $count,
            'user' => $user,
        ]);
    }
}
