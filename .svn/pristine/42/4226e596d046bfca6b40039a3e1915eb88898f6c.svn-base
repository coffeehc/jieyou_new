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
        $games = $this->_db->getGameInfoForPagation();
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

    /**
     * 推荐设置
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function recom($id=0) {
        if(request()->isPost()) {
            $data = input('post.');
            unset($data['box']);
            $data['tj'] = rtrim($data['tj'],',');
            $game = model('Game')->get($data['gid']);
            $data['banner_img'] = str_replace('\\','/',$data['banner_img']);
            // 当 game 数据表里面的 tj 字段为 0 的时候 判断为新增 否则 为修改
            if($game['tj'] == '0') {
                try {
                    $res = model('Adimg')->save($data);
                    $ret = model('Game')->update(['tj'=>$data['tj'],'id'=>$data['gid']]);
                    if($res && $ret) {
                        return show(1,'推荐成功');
                    }else {
                        return show(0,'推荐失败');
                    }
                } catch (\Exception $e) {
                    return show(0,$e->getMessage());
                }
            }else {
                try {
                    $res = model('Adimg')->where('gid='.$data['gid'])->update($data);
                    $ret = model('Game')->update(['tj'=>$data['tj'],'id'=>$data['gid']]);
                    if($res && $ret) {
                        return show(1,'推荐成功');
                    }else {
                        return show(0,'推荐失败');
                    }
                } catch (\Exception $e) {
                    return show(0,$e->getMessage());
                }
            }
        }else {
            $game = $this->_db->get($id);
            $image = model('Adimg')->where('gid='.$id)->find();
            return $this->fetch('',[
                'game' => $game,
                'banner_img' => !empty($image['banner_img']) ? $image['banner_img'] : '',
                'jingping_img' => !empty($image['jingping_img']) ? $image['jingping_img'] : '',
                'zhongbu_img' => !empty($image['zhongbu_img']) ? $image['zhongbu_img'] : '',
                'dibu_img' => !empty($image['dibu_img']) ? $image['dibu_img'] : '',
                'youshang_img' => !empty($image['youshang_img']) ? $image['youshang_img'] : '',
                'youxia_img' => !empty($image['youxia_img']) ? $image['youxia_img'] : '',
            ]);
        }
    }

    /**
     * 排序逻辑
     * @return [type] [description]
     */
    public function listorder() {
        if(!request()->isPost()) {
            return $this->error('请求错误');
        }
        $data = input('post.');
        try {
            $res = model('Game')->where('id',$data['id'])->update(['sort'=>$data['sort']]);
            if($res) {
                return show(1,'排序成功',$data['sort']);
            }else {
                return show(0,'排序失败');
            }
        } catch (\Exception $e) {
            return show(0,$e->getMessage());
        }

    }
}
