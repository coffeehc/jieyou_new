<?php
namespace app\api\controller;
use think\Controller;

/**
 * 更新用户资料
 */
class Updateuserinfo extends Controller {
    public function index() {
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        $data = input('post.');
        if(!is_numeric($data['id'])) {
            return show(0,'ID不合法');
        }
        try{
            $res = model('User')->update($data);
            if($res) {
                return show(1,'OK');
            }else {
                return show(0,'更新失败');
            }
        }catch(\Exception $e) { 
            return show(0,$e->getMessage());
        }
    }
}