<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  图片管理
 */
class Picture extends BaseController {

    /**
     * 图片列表
     * @return [type] [description]
     */
    public function index() {
        return $this->fetch();
    }

    /**
     * 添加图片
     */
    public function add() {
        return $this->fetch();
    }
}
