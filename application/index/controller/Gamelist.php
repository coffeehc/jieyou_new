<?php
namespace app\index\controller;
use think\Controller;

class Gamelist extends Controller {

    public function index() {
        return $this->fetch();
    }
}
