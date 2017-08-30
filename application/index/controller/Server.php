<?php
namespace app\index\controller;
use think\Controller;

class Server extends BaseController {

    public function index() {
        $gid = input('param.gid');
        $sdata = [];
        if(!empty($gid)) {
            $sdata['gid'] = $gid;
        }
        // 游戏分类
        $gameType = model('GameType')->getGameTypeInfo();
        // 开服列表
        $servers = model('GameServer')->getGameServerLimit($sdata);
        return $this->fetch('',[
            'gameType' => $gameType,
            'servers' => $servers,
        ]);
    }
}
