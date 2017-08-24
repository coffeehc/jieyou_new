<?php
namespace app\admin\controller;
use think\Controller;

class Game extends BaseController {
    private $_db;
    public function _initialize() {
        $this->_db = model('Game');
    }
    /**
     * 网页游戏列表
     * @return [type] [description]
     */
    public function index() {
        $games = $this->_db->getGameInfo();
        $count = $this->_db->getGameCount();
        return $this->fetch('',[
            'games' => $games,
            'count' => $count,
        ]);
    }

    public function add() {
        return $this->fetch();
    }
}
