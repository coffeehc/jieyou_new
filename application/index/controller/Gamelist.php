<?php
namespace app\index\controller;
use think\Controller;

class Gamelist extends BaseController {

    /**
     * 游戏大厅首页
     * @return [type] [description]
     */
    public function index() {
        $condition = ['lxid','zm'];
        $lxid = $zm = '';

        foreach ($condition as $value) {
            if(isset($_GET[$value])) {
                $$value = $_GET[$value];
            }
        }

        $data = input('get.');
        $sdata = [];
        if(isset($data['lxid']) && $data['lxid'] != '0') {
            $sdata['lxid'] = $data['lxid'];
        }
        if(isset($data['zm']) && $data['zm'] != '0') {
            $sdata['zm'] = $data['zm'];
        }
        // 游戏分类
        $gameType = model('GameType')->getGameTypeInfo();
        // 游戏列表
        $games = model('Game')->getGameInfoForPagation($sdata,16);
        // 最新开服
        $newServer = model('GameServer')->getNewServer();
        // 游戏公告
        $gameArticle = model('Article')->getGameArticle();
        $articleEmpty = '<div class="cheng" align="center">当前没有公告</div>';
        // 循环得到 A-Z
        foreach (range('A','Z') as $v) {
            $zmArray[] = $v;
        }
        return $this->fetch('',[
            'gameType' => $gameType,
            'games' => $games,
            'newServer' => $newServer,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'sdata' => $data,
            'zmArray' => $zmArray,
            'lxid' => $lxid,
            'zm' => $zm,
        ]);
    }
}
