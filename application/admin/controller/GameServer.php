<?php
namespace app\admin\controller;
use think\Controller;

class GameServer extends BaseController {

    private $_db;
    public function _initialize() {
        $this->_db = model('GameServer');
    }

    /**
     * 游戏服务器主页
     * @param  string $gid [description]
     * @return [type]      [description]
     */
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

    /**
     * 服务器添加功能
     */
    public function add() {
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        $data = input('post.');
        $validate = validate('GameServer');
        if(!$validate->scene('add')->check($data)) {
            return show(0,$validate->getError());
        }
        $data['name'] = '双线'.$data['sid'].'区';
        $data['game'] = getGameNameById($data['gid']);
        $data['create_time'] = strtotime($data['create_time']);
        $data['ptid'] = 2;
        try {
            $res = $this->_db->insert($data);
            if($res) {
                return show(1,'添加成功');
            }else {
                return show(0,'添加失败');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * 服务器修改操作
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function edit($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('GameServer');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            $data['name'] = '双线'.$data['sid'].'区';
            $data['game'] = getGameNameById($data['gid']);
            $data['create_time'] = strtotime($data['create_time']);
            $data['ptid'] = 2;
            try {
                $res = $this->_db->where('id',$data['id'])->update($data);
                if($res) {
                    return show(1,'更新成功');
                }else {
                    return show(0,'更新失败');
                }
            } catch (\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $server = $this->_db->get($id);
            $games = model('Game')->getGameInfo();
            return $this->fetch('',[
                'server' => $server,
                'games' => $games,
            ]);
        }
    }
}
