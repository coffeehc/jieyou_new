<?php
namespace app\admin\controller;
use think\Controller;

class Game extends Controller {

    public function index() {
        return $this->fetch();
    }

}
