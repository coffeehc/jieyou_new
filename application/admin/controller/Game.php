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
            // 获取游戏名字首字母 并大写
            $data['zm'] = strtoupper(substr($data['gid'],0,1));
            // 获取平台名字
            $data['pt'] = getGamePtNameByPtid($data['ptid']);
            // 游戏类型名字
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

    /**
     * 修改游戏
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function edit($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('Game');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            // 获取游戏名字首字母 并大写
            $data['zm'] = strtoupper(substr($data['gid'],0,1));
            // 获取平台名字
            $data['pt'] = getGamePtNameByPtid($data['ptid']);
            // 游戏类型名字
            $data['lx'] = getGametypeNameByLxid($data['lxid']);
            try {
                $res = $this->_db->save($data,['id'=>$data['id']]);
                if($res) {
                    return show(1,'修改成功');
                }else {
                    return show(0,'修改失败');
                }
            } catch (\Exception $e) {
                return show(0,$e->getMessage());
            }

        }else {
            $game = $this->_db->get($id);
            $gamePt = model('Apikey')->getGamePt();
            $gameClass = model('GameType')->getGameTypeInfo();
            return $this->fetch('',[
                'gamePt' => $gamePt,
                'gameClass' => $gameClass,
                'game' => $game,
            ]);
        }
    }
}
