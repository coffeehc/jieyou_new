<?php
namespace app\index\controller;
use think\Controller;

class Server extends Controller {

    public function index() {
        return $this->fetch();
    }
}
