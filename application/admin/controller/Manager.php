<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 管理员管理
 */
class Manager extends Controller {
    private $_db;
    public function _initialize() {
        $this->_db = model('Manager');
    }
    /**
     * 管理员列表
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['start_time']) < strtotime($data['end_time'])) {
            $sdata['update_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['manager'])) {
            $sdata['manager'] = ['like','%'.$data['manager'].'%'];
        }
        $managers = $this->_db->getManagerInfo($sdata);
        $count = $this->_db->getManagerCount($sdata);
        return $this->fetch('',[
            'managers' => $managers,
            'count' => $count,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : '',
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : '',
            'manager' => !empty($data['manager']) ? $data['manager'] : '',
        ]);
    }

    /**
     * 添加管理员
     */
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Manager');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            unset($data['password_confirm']);
            try{
                $res = $this->_db->save($data);
                if($res) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $auth = config('manager.auth');
            return $this->fetch('',[
                'auth' => $auth,
            ]);
        }
    }
}
