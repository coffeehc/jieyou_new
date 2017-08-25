<?php
namespace app\admin\controller;
use think\Controller;

class GameServer extends Controller {

    private $_db;
    public function _initialize() {
        $this->_db = model('GameServer');
    }

    public function index($gid='') {
        $sdata = [];
        if(!empty($gid)) {
            $sdata['gid'] = $gid;
        }
        $gameServers = $this->_db->getGameServerInfo($sdata);
        $games = model('Game')->getGameInfo();
        return $this->fetch('',[
            'games' => $games,
            'gameServers' => $gameServers,
        ]);
    }
}
