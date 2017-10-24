<?php
namespace app\index\controller;
use think\Controller;

class Index extends BaseController
{
    public function index()
    {
        // 精品推荐游戏
        $jingping_img = model('Adimg')->getJingpingImg();
        // 热门游戏
        $hotGames = model('Game')->getHotGame();
        // 最新游戏
        $newGames = model('Game')->getNewGame();
        // 最新开服
        $newServer = model('GameServer')->getNewServer();
        // 开服预告
        $readyServer = model('GameServer')->getReadyServer();
        $readyEmpty = '<tr><td height="50" colspan="3" align="center" class="cheng">还没有游戏开服</td></tr>';
        // 游戏公告
        $gameArticle = model('Article')->getGameArticle();
        $articleEmpty = '<div class="cheng" align="center">当前没有公告</div>';
        // 玩家墙
        $users = model('User')->getUserRand();
        // 友情链接
        $links = model('Link')->getLinkInfo();
        // 首页中部广告
        $zhongbu_img = model('Adimg')->getZhongbuImg();
        // 首页底部广告
        $dibu_img = model('Adimg')->getDibuImg();
        // 首页右上广告
        $youshang_img = model('Adimg')->getYoushangImg();
        // 首页右下广告
        $youxia_img = model('Adimg')->getYouxiaImg();

        return $this->fetch('',[
            'jingping_img' => $jingping_img,
            'hotGames' => $hotGames,
            'newGames' => $newGames,
            'newServer' => $newServer,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
            'gameArticle' => $gameArticle,
            'users' => $users,
            'links' => $links,
            'zhongbu_img' => $zhongbu_img,
            'dibu_img' => $dibu_img,
            'youshang_img' => $youshang_img,
            'youxia_img' => $youxia_img,
        ]);
    }
}
