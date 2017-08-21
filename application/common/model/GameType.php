<?php
namespace app\common\model;
use think\Model;

class GameType extends BaseModel {

    public function getGameTypeInfo() {
        $order = [
            'sort' => 'desc',
            'id' => 'desc',
        ];

        $res = $this->order($order)->select();
        return $res;
    }

    public function getGameTypeCount() {
        $res = $this->count();
        return $res;
    }
}
