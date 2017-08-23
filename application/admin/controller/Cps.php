<?php
namespace app\admin\controller;
use think\Controller;

class Cps extends Controller {

    /**
     * CPS 列表
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.users');
        $sdata = [];
        if(!empty($data)) {
            $sdata['users'] = ['like','%'.$data.'%'];
        }
        $users = model('User')->getUserInfoForCps($sdata);
        $count = model('User')->getUserCount($sdata);
        return $this->fetch('',[
            'users' => $users,
            'count' => $count,
            'name' => !empty($data) ? $data : '',
        ]);
    }
}
