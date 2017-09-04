<?php
namespace app\index\controller;
use think\Controller;

class Game extends BaseController {

    public function index() {
        if(request()->isPost()) {
            $data = input('post.');
            if($data['qx'] == 1) {  // 新账号注册
                if(empty($data['users1'])) {
                    return show(0,'账号不能为空');
                }
                if(empty($data['password'])) {
                    return show(0,'密码不能为空');
                }
                if(model('User')->getUserByUsername($data['users1'])) {
                    return show(0,'用户名已存在');
                }
                $data['users'] = $data['users1'];
                try {
                    $res = model('User')->allowField(true)->save($data);
                    if($res) {
                        return show(1,'注册成功');
                    }else {
                        return show(0,'注册失败');
                    }
                } catch (\Exception $e) {
                    return show(0,$e->getMessage());
                }

            }else if($data['qx'] == 2) {  // 老账号注册
                if(empty($data['users2'])) {
                    return show(0,'账号不能为空');
                }
                if(empty($data['password'])) {
                    return show(0,'密码不能为空');
                }
                $data['users'] = $data['users2'];
                $user = model('User')->getUserByUsername($data['users']);
                if($user && $user['password'] == $data['password']) {
                    session('user',$user,'index');
                    model('User')->allowField(true)->where('id',$user['id'])->setInc('hits');
                    model('User')->allowField(true)->where('id',$user['id'])->update(['update_time'=>time()]);
                    return show(1,$user['users'].'欢迎您！');
                }else {
                    return show(0,'用户名或密码错误');
                }
            }
        }else {
            
            return $this->fetch();
        }
    }
}
