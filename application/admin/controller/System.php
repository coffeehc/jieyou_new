<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  系统管理
 */
class System extends Controller {

    /**
     *  系统设置
     * @return [type] [description]
     */
    public function index() {
        return $this->fetch();
    }

    /**
     * APIKEY设置
     * @return [type] [description]
     */
    public function apikey() {
        return $this->fetch();
    }

    /**
     *  支付管理
     * @return [type] [description]
     */
    public function pay() {
        return $this->fetch();
    }

    /**
     *  添加支付渠道
     */
    public function addPay() {
        return $this->fetch();
    }

    /**
     *  添加支付方式
     */
    public function addPayway() {
        return $this->fetch();
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
}
