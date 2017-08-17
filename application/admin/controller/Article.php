<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  咨询管理
 */
class Article extends Controller {

    /**
     * 咨询列表页
     * @return [type] [description]
     */
    public function index() {
        return $this->fetch();
    }

    /**
     * 添加咨询
     */
    public function add() {
        return $this->fetch();
    }
}
