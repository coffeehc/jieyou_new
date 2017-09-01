<?php
namespace app\index\controller;
use think\Controller;

class Youxi extends BaseController {

    /**
     * 游戏页面
     * @return [type] [description]
     */
    public function index() {
        $id = input('param.');
        $youxi = model('Game')->get($id);
        $youxi['picmax'] = str_replace('\\','/',$youxi['picmax']);
        return $this->fetch('',[
            'youxi' => $youxi,
        ]);
    }
}
