<?php
namespace app\common\model;
use think\Model;

class UserServer extends Model {

    /**
     * 通过用户ID 获取用户玩过的游戏
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getPlayedGameByUid($id) {
        $res = $this->field(true)->where('userid='.$id)->order('create_time desc')->paginate();
        return $res;
    }
}
