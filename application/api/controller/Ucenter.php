<?php
namespace app\api\controller;
use think\Controller;

class Ucenter extends Controller {
    public function index() {
        include APP_PATH."ucenter/api/uc.php";
    }
}
