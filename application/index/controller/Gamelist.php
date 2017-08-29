<?php
namespace app\index\controller;
use think\Controller;

class Gamelist extends BaseController {

    /**
     * 游戏大厅首页
     * @return [type] [description]
     */
    public function index() {
        // 游戏分类
        $gameType = model('GameType')->getGameTypeInfo();
        // 游戏列表
        $games = model('Game')->getGameInfo();
        // 最新开服
        $newServer = model('GameServer')->getNewServer();
        // 游戏公告
        $gameArticle = model('Article')->getGameArticle();
        $articleEmpty = '<div class="cheng" align="center">当前没有公告</div>';
        return $this->fetch('',[
            'gameType' => $gameType,
            'games' => $games,
            'newServer' => $newServer,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
        ]);
    }
}
