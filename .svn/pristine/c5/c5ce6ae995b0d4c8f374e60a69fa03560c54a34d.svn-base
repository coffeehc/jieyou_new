<?php
namespace app\index\controller;
use think\Controller;

class Youxi extends BaseController {

    /**
     * 游戏页面
     * @return [type] [description]
     */
    public function index() {
        $data = input('param.');
        $youxi = model('Game')->get($data['id']);

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

        $isUser = $this->getLoginUser();
        $kaishiyouxi = 0;
        if(!$isUser) {
            if(!$recServer->isEmpty()) {
                $kaishiyouxi = $recServer[0]['id'];
            }
        }else {
            $isPlayedGame = model('UserServer')->getIsPlayedGame($isUser['id'],$data['id']);
            if($isPlayedGame) {
                $kaishiyouxi =$isPlayedGame['id'];
            }else {
                if(!$recServer->isEmpty()) {
                    $kaishiyouxi = $recServer[0]['id'];
                }
            }
        }


        return $this->fetch('',[
            'youxi' => $youxi,
            'readyServer' => $readyServer,
            'readyEmpty' => $readyEmpty,
            'gameArticle' => $gameArticle,
            'articleEmpty' => $articleEmpty,
            'recServer' => $recServer,
            'gameServer' => $gameServer,
            'kaishiyouxi' => $kaishiyouxi,
            'emptyServer' => $emptyServer,
        ]);
    }
}
