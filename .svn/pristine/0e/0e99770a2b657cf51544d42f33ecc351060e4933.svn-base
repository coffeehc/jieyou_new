<?php
namespace app\admin\controller;
use think\Controller;

class BaseController extends Controller {

    public $manager;
    public function _initialize() {
        $isLogin = $this->isLogin();
        if(!$isLogin) {
            return $this->redirect('login/index');
        }
    }

    public function isLogin() {
        $user = $this->getLoginUser();
        if($user && $user->id) {
            return true;
        }
        return false;
    }

    public function getLoginUser() {
        if(!$this->manager) {
            $this->manager = session('manager','','admin');
        }
        return $this->manager;
    }

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

    /**
     * 批量删除
     * @return [type] [description]
     */
    public function delDatas () {
        $ids = rtrim(input('post.ids'),',');
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $model = request()->controller();
            $res = model($model)->where('id IN'.'('.$ids.')')->delete();
            if($res) {
                return show(1,'删除成功');
            }else {
                return show(0,'删除失败');
            }
        }catch(\Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * 改变状态
     */
    public function setStatus() {
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        $data = input('post.');
        if(!$data['id']) {
            return show(0,'ID不合法');
        }
        try{
            $model = request()->controller();
            $res = model($model)->where('id',intval($data['id']))->update(['status'=>intval($data['status'])]);
            if($res) {
                return show(1,'更新成功');
            }else {
                return show(0,'更新失败');
            }
        }catch(\Exception $e) {
            return show(0,$e->getMessage());
        }
    }
}
