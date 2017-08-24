<?php
namespace app\common\model;
use think\Model;

class Apikey extends Model {

    public function getApikeyInfo() {
        $order = [
            'id' => 'desc',
        ];
        $res = $this->order($order)->select();
        return $res;
    }

    public function getApikeyCount() {
        $res = $this->count();
        return $res;
    }

    /**
     * 获取游戏平台
     * @return [type] [description]
     */
    public function getGamePt() {
        $res = $this->field('id,name')->select();
        return $res;
    }
}
