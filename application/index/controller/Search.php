<?php
namespace app\index\controller;
use think\Controller;

class Search extends BaseController {

    public function index() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }

        $gameName = input('post.name');
        $game = model('Game')->getGameInfoByGameName($gameName);
        if(!$game) {
            return show(0,'没有相关游戏');
        }else {
            return show(1,'',$game);
        }
    }
}
