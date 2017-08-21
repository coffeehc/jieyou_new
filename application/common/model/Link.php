<?php
namespace app\common\model;
use think\Model;

class Link extends Model {

    public function getLinkInfo() {
        $order = [
            'id' => 'desc',
        ];
        $res = $this->order($order)->select();
        return $res;
    }

    public function getLinkCount() {
        $res = $this->count();
        return $res;
    }
}
