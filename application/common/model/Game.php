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
        $res = $this->where($data)->order($order)->select();
        return $res;
    }
    public function getGameCount($data=[]) {
        $res = $this->where($data)->count();
        return $res;
    }

    public function getGameInfoForPagation($data=[]) {
        $order = [
            'sort' => 'desc',
            'tj' => 'desc',
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order)->paginate(8);
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
}
