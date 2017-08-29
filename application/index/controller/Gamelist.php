<?php
namespace app\index\controller;
use think\Controller;

class Gamelist extends BaseController {

    public function index() {
        return $this->fetch();
    }
}
