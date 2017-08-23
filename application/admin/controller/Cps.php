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

    /**
     * CPS 分成设置
     * @return [type] [description]
     */
    public function cpsSet() {
        if(request()->isPost()) {
            $data = input('post.');
            try {
                $res = model('Config')->update(['cps'=>$data['cps'],'id'=>$data['id']]);
                if($res) {
                    return show(1,'设置成功');
                }else {
                    return show(0,'设置失败');
                }
            } catch (\Exception $e) {
                return show(0,$e->getMessage());
            }

        }else {
            $cps = model('Config')->getCpsInfo();
            return $this->fetch('',[
                'cps' => $cps,
            ]);
        }
    }
}
