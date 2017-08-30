<?php
namespace app\common\model;
use think\Model;

class Game extends Model {
    public function getGameInfo($data=[]) {
        $order = [
            'sort' => 'desc',
            'tj' => 'desc',
            'id' => 'desc',
        ];
        $res = $this->field(true)->where($data)->order($order)->select();
        return $res;
    }
    public function getGameCount($data=[]) {
        $res = $this->where($data)->count();
        return $res;
    }

    public function getGameInfoForPagation($data=[],$pageSize=8) {
        $order = [
            'sort' => 'desc',
            'tj' => 'desc',
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order)->paginate($pageSize);
        return $res;
    }

    /**
     * 首页热门游戏
     * @return [type] [description]
     */
    public function getHotGame() {
        $res = $this
                ->field('id,pic3,name')
                ->order('hits desc')
                ->limit(8)
                ->select();
        return $res;
    }

    /**
     * 获取最新游戏
     * @return [type] [description]
     */
    public function getNewGame() {
        $res = $this
                ->field('id,pic3,name')
                ->order('id desc')
                ->limit(8)
                ->select();
        return $res;
    }

    /**
     * 根据游戏类型获取游戏
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getGameByGameType($id) {
        $res = $this
                ->field('id','name')
                ->where('lxid='.$id)
                ->select();
        return $res;
    }
}
