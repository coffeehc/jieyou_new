<?php
namespace app\common\model;
use think\Model;

class Config extends Model {

    public function getConfigInfo() {
        $res = $this->field(true)->find();
        return $res;
    }

    public function getCpsInfo() {
        $res = $this->field('id,cps')->find();
        return $res;
    }
}
