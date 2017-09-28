<?php
namespace app\admin\controller;
use think\Controller;

class GameType extends BaseController {
    private $_db;
    public function _initialize() {
        $this->_db = model('GameType');
    }
    /**
     * 游戏类型列表
     * @return [type] [description]
     */
    public function index() {
        $gameTypes = $this->_db->getGameTypeInfo();
        $count = $this->_db->getGameTypeCount();
        return $this->fetch('',[
            'gameTypes' => $gameTypes,
            'count' => $count,
        ]);
    }

    /**
     * 添加分类
     */
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('GameType');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = $this->_db->save($data);
                if($res) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            return $this->fetch();
        }
    }

    /**
     * 修改
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function edit($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            $validate = validate('GameType');
            if(!$validate->scene('add')->check($data)) {
                return show(0,$validate->getError());
            }
            try{
                $res = model('GameType')->save($data,['id'=>intval($data['id'])]);
                if($res) {
                    return show(1,'修改成功');
                }else {
                    return show(0,'修改失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $gameType = $this->_db->get($id);
            return $this->fetch('',[
                'gameType' => $gameType,
            ]);
        }
    }
}
