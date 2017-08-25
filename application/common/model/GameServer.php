<?php
namespace app\common\model;
use think\Model;

class GameServer extends Model {

    public function getGameServerInfo($data=[]) {
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)->order($order)->select();
        return $res;
    }

    /**
     * 服务器数量
     * @return [type] [description]
     */
    public function getGameserverCount() {
        $res = $this->count();
        return $res;
    }

    /**
     * 已经开区服务器
     * @return [type] [description]
     */
    public function getGameserverOpenedCount() {
        $res = $this->where('create_time < now()')->count();
        return $res;
    }

    /**
     * 即将开区服务器
     * @return [type] [description]
     */
    public function getGameserverOpenCount() {
        $res = $this->where('create_time >= now()')->count();
        return $res;
    }
}
