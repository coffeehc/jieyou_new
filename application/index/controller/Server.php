<?php
namespace app\index\controller;
use think\Controller;

class Server extends BaseController {

    public function index() {
        return $this->fetch();
    }
}
