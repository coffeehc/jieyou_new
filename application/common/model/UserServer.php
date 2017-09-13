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

    /**
     * 登录玩家对应的这款游戏的信息  玩过就返回数据 没玩过就flase
     * @return [type] [description]
     */
    public function getIsPlayedGame($uid,$sid) {
        $res = $this->field(true)->where("userid = $uid and gsid = $sid")->find();
        return $res;
    }

    public function getGsidByUserid($uid) {
        $res = $this->field('gsid')->where("userid = $uid")->order('id desc')->find();
        return $res['gsid'];
    }
}
