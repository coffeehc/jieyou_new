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
        // 图片路径
        $youxi['picmax'] = str_replace('\\','/',$youxi['picmax']);

        // 近期将要开放的服务器
        $readyServer = model('GameServer')->getReadyServerByGid($youxi['gid']);
        $readyEmpty = '<tr><td height="100" colspan="3" align="center" class="cheng">敬请期待</td></tr>';

        // 游戏资讯
        $gameArticle = model('Article')->getGameArticleByGid($youxi['id']);
        $articleEmpty = '<div align="center" style="height:50px;padding-top:30px">暂时还没有游戏资讯!</div>';

        // 推荐服务器
        $recServer = model('GameServer')->getRecServerByGid($youxi['gid']);

        // 所有服务器
        $gameServer = model('GameServer')->getGameServerByGid($youxi['gid']);
        return $this->fetch('',[
            'youxi' => $youxi,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'recServer' => $recServer,
            'gameServer' => $gameServer,
        ]);
    }
}
