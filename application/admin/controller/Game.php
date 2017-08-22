<?php
namespace app\admin\controller;
use think\Controller;

class Game extends BaseController {

    public function index() {
        return $this->fetch();
    }

}
