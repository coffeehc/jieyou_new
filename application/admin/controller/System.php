<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  系统管理
 */
class System extends BaseController {

    /**
     *  系统设置
     * @return [type] [description]
     */
    public function index() {
        if(request()->isPost()) {
            $data = input('post.');
            try{
                $res = model('Config')->allowField(true)->save($data,['id'=>$data['id']]);
                if($res) {
                    return show(1,'修改成功');
                }else {
                    return show(0,'修改失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $config = model('Config')->getConfigInfo();
            return $this->fetch('',[
                'config' => $config,
            ]);
        }
    }

    /**
     * APIKEY设置
     * @return [type] [description]
     */
    public function apikey() {
        $apikeys = model('Apikey')->getApikeyInfo();
        $count = model('Apikey')->getApikeyCount();
        return $this->fetch('',[
            'apikeys' => $apikeys,
            'count' => $count,
        ]);
    }

    /**
     *  新增apikey
     */
    public function addApikey() {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Apikey');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = model('Apikey')->save($data);
                if($res) {
                    return show(1,'新增成功');
                }else {
                    return show(0,'新增失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            return $this->fetch();
        }
    }

    /**
     * 修改apikey
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function editApikey($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Apikey');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = model('Apikey')->save($data,['id'=>intval($data['id'])]);
                if($res) {
                    return show(1,'修改成功');
                }else {
                    return show(0,'修改失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $apikey = model('apikey')->get($id);
            return $this->fetch('',[
                'apikey' => $apikey,
            ]);
        }
    }

    /**
     *  删除apikey
     * @return [type] [description]
     */
    public function delApikey() {
        $id = intval(input('post.id'));
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $res = model('Apikey')->where('id',$id)->delete();
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
     * 批量删除apikey
     * @return [type] [description]
     */
    public function delApikeys() {
        $ids = rtrim(input('post.ids'),',');
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $res = model('Apikey')->where('id IN'.'('.$ids.')')->delete();
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
     * 友情链接
     * @return [type] [description]
     */
    public function link() {
        $links = model('Link')->getLinkInfo();
        $count = model('Link')->getLinkCount();
        return $this->fetch('',[
            'links' => $links,
            'count' => $count,
        ]);
    }

    /**
     * 添加友情链接
     */
    public function addLink() {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Link');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = model('Link')->save($data);
                if($res) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            return $this->fetch();
        }
    }

    /**
     * 修改链接
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function editLink($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Link');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = model('Link')->save($data,['id'=>intval($data['id'])]);
                if($res) {
                    return show(1,'更新成功');
                }else {
                    return show(0,'更新失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $link = model('Link')->get($id);
            return $this->fetch('',[
                'link' => $link,
            ]);
        }
    }

    /**
     * 删除链接
     * @return [type] [description]
     */
    public function delLink() {
        $id = intval(input('post.id'));
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $res = model('Link')->where('id',$id)->delete();
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
     * 批量删除链接
     * @return [type] [description]
     */
    public function delLinks() {
        $ids = rtrim(input('post.ids'),',');
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $res = model('Link')->where('id IN'.'('.$ids.')')->delete();
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
