<?php
namespace app\admin\controller;
use think\Controller;

class BaseController extends Controller {

    /**
     * 删除数据
     * @return [type] [description]
     */
    public function delData() {
        $id = intval(input('post.id'));
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $model = request()->controller();
            $res = model($model)->delData($id);
            if($res) {
                return show(1,'删除成功');
            }else {
                return show(0,'删除失败');
            }
        }catch(\Exception $e) {
            return show(0,$e->getMessage());
        }
    }
}
