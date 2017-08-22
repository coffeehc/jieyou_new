<?php
namespace app\common\model;
use think\Model;

class Game extends Model {
    public function getGameInfo() {
        $res = $this->select();
        return $res;
    }
    public function getGameCount() {
        $res = $this->count();
        return $res;
    }
}
