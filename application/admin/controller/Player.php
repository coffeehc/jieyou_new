<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  玩家管理
 */
class Player extends Controller {

    /**
     *  玩家列表
     * @return [type] [description]
     */
    public function index() {
        return $this->fetch();
    }
}
