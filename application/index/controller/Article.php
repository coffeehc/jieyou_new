<?php
namespace app\index\controller;
use think\Controller;

class Article extends BaseController {

    /**
     * 资讯列表页面
     * @return [type] [description]
     */
    public function index() {
        // 资讯列表
        $article = model('Article')->getNormalArticle();
        // 最新开服
        $newServer = model('GameServer')->getNewServer();
        // 游戏公告
        $gameArticle = model('Article')->getGameArticle();
        $articleEmpty = '<div class="cheng" align="center">当前没有公告</div>';
        // 开服预告
        $readyServer = model('GameServer')->getReadyServer();
        $readyEmpty = '<tr><td height="50" colspan="3" align="center" class="cheng">还没有游戏开服</td></tr>';
        return $this->fetch('',[
            'article' => $article,
            'newServer' => $newServer,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
        ]);
    }

    /**
     * 资讯详情页面
     * @return [type] [description]
     */
    public function news() {
        $id = input('param.');
        $news = model('Article')->get($id);
        // 最新开服
        $newServer = model('GameServer')->getNewServer();
        // 游戏公告
        $gameArticle = model('Article')->getGameArticle();
        $articleEmpty = '<div class="cheng" align="center">当前没有公告</div>';
        // 开服预告
        $readyServer = model('GameServer')->getReadyServer();
        $readyEmpty = '<tr><td height="50" colspan="3" align="center" class="cheng">还没有游戏开服</td></tr>';
        return $this->fetch('',[
            'news' => $news,
            'newServer' => $newServer,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
        ]);
    }
}
