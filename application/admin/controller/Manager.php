<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 管理员管理
 */
class Manager extends Controller {

    /**
     * 管理员列表
     * @return [type] [description]
     */
    public function index() {
        return $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function add() {
        return $this->fetch();
    }
}
