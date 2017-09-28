<?php
namespace app\common\model;
use think\Model;

class Flash extends Model {

    public function getFlashInfo() {
        $res = $this->paginate();
        return $res;
    }

    public function getFlashCount() {
        $res = $this->count();
        return $res;
    }

    /**
     * 通过游戏GID 获取flash信息
     * @return [type] [description]
     */
    public function getFlashInfoByGid($gid) {
        $res = $this->field(true)->where("gid = '$gid'")->find();
        return $res;
    }
}
