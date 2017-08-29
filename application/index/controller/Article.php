<?php
namespace app\index\controller;
use think\Controller;

class Article extends BaseController {

    public function index() {
        return $this->fetch();
    }
}
