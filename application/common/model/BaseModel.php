<?php
namespace app\common\model;
use think\Model;

class BaseModel extends Model {

    public function delData($id) {
        $res = $this->where('id',$id)->delete();
        return $res;
    }
}
