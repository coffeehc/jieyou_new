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

    /**
     * 添加游戏
     */
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Game');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            $data['zm'] = strtoupper(substr($data['gid'],0,1));
            $data['pt'] = getGamePtNameByPtid($data['ptid']);
            $data['lx'] = getGametypeNameByLxid($data['lxid']);
            try {
                $res = $this->_db->save($data);
                if($res) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            } catch (\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $gamePt = model('Apikey')->getGamePt();
            $gameClass = model('GameType')->getGameTypeInfo();
            return $this->fetch('',[
                'gamePt' => $gamePt,
                'gameClass' => $gameClass,
            ]);
        }
    }
}
