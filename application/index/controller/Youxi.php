<?php
namespace app\index\controller;
use think\Controller;

class Youxi extends BaseController {

    private $data = [];
    private $youxi = [];
    private $recServer = [];
    private $gameServer = [];
    private $jijServer = [];
    /**
     * 初始化
     */
    public function _initialize() {
        parent::_initialize();
        $this->data = input('param.');
        $this->youxi = model('Game')->get($this->data['id']);
        // 图片路径转换
        $this->youxi['picmax'] = str_replace('\\','/',$this->youxi['picmax']);
        // 推荐服务器
        $this->recServer = model('GameServer')->getRecServerByGid($this->youxi['gid']);
        
        // 所有服务器
        $this->gameServer = model('GameServer')->getGameServerByGid($this->youxi['gid']);
        // 即将开启服务器
        $this->jijServer = model('GameServer')->getReadyServerByGid($this->youxi['gid']);
    }

    /**
     * 游戏页面
     * @return [type] [description]
     */
    public function index() {
        $data = $this->data;
        $youxi = $this->youxi;
        // 推荐服务器
        $recServer = $this->recServer;
        // 所有服务器
        $gameServer = $this->gameServer;  
        // 即将开启服务器
        $jijServer = $this->jijServer;

        // 近期将要开放的服务器
        $readyServer = model('GameServer')->getReadyServerByGid($youxi['gid']);
        $readyEmpty = '<tr><td height="100" colspan="3" align="center" class="cheng">敬请期待</td></tr>';

        // 游戏资讯
        $gameArticle = model('Article')->getGameArticleByGid($youxi['id']);
        $articleEmpty = '<div align="center" style="height:50px;padding-top:30px">暂时还没有游戏资讯!</div>';

        $emptyServer = '<div>
                            <span class="cheng">游戏还有</span>
                            <span id="_d">00</span>
                            <span id="_h">00</span>
                            <span id="_m">00</span>
                            <span id="_s">00</span>
                            <span class="cheng">开服，敬请期待</span>
                        </div>';

        // 来源统计
        if(isset($data['ly']) && $data['ly'] != '') {
            $ip = $_SERVER["REMOTE_ADDR"];
            $insertData['url'] = hc_filter($data['ly']);
            $insertData['gid'] = $youxi['gid'];
            $gid = $youxi['gid'];
            $insertData['register'] = 0;
            $insertData['ip'] = ip2long($ip);
            if($insertData['ip'] < 0) {
                $insertData['ip'] = intval(sprintf('%u',ip2long($ip)));
            }
            $res = model("Stats")->where('ip = '.$insertData['ip']." and gid = '$gid'")->order('create_time desc')->find();
            // 限制 在一分钟之内请求页面 只算一次有效
            if(!$res || ($res['create_time']+60) < time()) {
                model('Stats')->save($insertData);
                $statsId = model('Stats')->getLastInsID();
            }else {
                $statsId = $res['id'];
            }
            session('sid',$statsId,'index');
        }

        // $isUser = $this->getLoginUser();
        // $kaishiyouxi = 0;
        // if(!$isUser) {
        //     if(!$recServer->isEmpty()) {
        //         $kaishiyouxi = $recServer[0]['id'];
        //     }
        // }else {
        //     $isPlayedGame = model('UserServer')->getIsPlayedGame($isUser['id'],$data['id']);
        //     if($isPlayedGame) {
        //         $kaishiyouxi =$isPlayedGame['id'];
        //     }else {
        //         if(!$recServer->isEmpty()) {
        //             $kaishiyouxi = $recServer[0]['id'];
        //         }
        //     }
        // }


        return $this->fetch('',[
            'youxi' => $youxi,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'recServer' => $recServer,
            'gameServer' => $gameServer,
            // 'kaishiyouxi' => $kaishiyouxi,
            'emptyServer' => $emptyServer,
            'jijServer' => $jijServer,
        ]);
    }

    /**
     * 服务器列表页
     * @return [type] [description]
     */
    public function server() {
        $data = $this->data;
        $youxi = $this->youxi;
        // 推荐服务器
        $recServer = $this->recServer;
        // 所有服务器
        $gameServer = $this->gameServer; 
        // 即将开启服务器
        $jijServer = $this->jijServer;

        return $this->fetch('',[
            'youxi' => $youxi,
            'recServer' => $recServer,
            'gameServer' => $gameServer,
            'jijServer' => $jijServer,
        ]);
    }

    /**
     * 文章列表页面
     * @return [type] [description]
     */
    public function article() {
        $data = $this->data;
        $youxi = $this->youxi;
        // 所有服务器
        $gameServer = $this->gameServer; 
        // 游戏资讯
        $gameArticle = model('Article')->getGameArticleByGid($youxi['id']);
        // 即将开启服务器
        $jijServer = $this->jijServer;

        return $this->fetch('',[
            'youxi' => $youxi,
            'gameServer' => $gameServer,
            'gameArticle' => $gameArticle,
            'jijServer' => $jijServer,
        ]);
    }

     /**
     * 文章详情页面
     * @return [type] [description]
     */
    public function news() {
        $data = $this->data;
        $youxi = $this->youxi;
        // 所有服务器
        $gameServer = $this->gameServer; 
        // 游戏资讯
        $gameArticle = model('Article')->getGameArticleByGid($youxi['id']);
        // 即将开启服务器
        $jijServer = $this->jijServer;
        // 文章详情页面
        $news = model('Article')->get($data['aid']);

        return $this->fetch('',[
            'youxi' => $youxi,
            'gameServer' => $gameServer,
            'gameArticle' => $gameArticle,
            'jijServer' => $jijServer,
            'news' => $news,
        ]);
    }

    /**
     * 新手礼包页面
     */
    public function xinshouka() {
        $data = $this->data;
        $youxi = $this->youxi;
        // 所有服务器
        $gameServer = $this->gameServer; 
        // 即将开启服务器
        $jijServer = $this->jijServer;

        // 游戏对于的服务器列表
        $serverList = model('GameServer')->getGameServerByGid($youxi['gid']);
        return $this->fetch('',[
            'youxi' => $youxi,
            'gameServer' => $gameServer,
            'serverList' => $serverList,
            'jijServer' => $jijServer,
        ]);
    }
}
