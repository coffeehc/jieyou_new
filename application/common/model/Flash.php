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
}
