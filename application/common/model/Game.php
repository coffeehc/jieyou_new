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
}
