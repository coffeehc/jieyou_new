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

    /**
     * 通过用户ID 获取 gsid字段数据
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function getGsidInfoByUid($uid) {
        $res = $this->field('gsid')->where("userid = $uid")->order("id desc")->select();
        return $res;
    }

    public function getGidByUid($uid) {
        $res = $this->field('gid')->where("userid = $uid")->group("gid")->select();
        return $res;
    }

    /**
     * 通过用户ID 和 游戏GID 获取最近玩过的游戏服务
     * @param  [type] $uid [description]
     * @param  [type] $gid [description]
     * @return [type]      [description]
     */
    public function getLastPlayedByUidAndGid($uid,$gid) {
        $res = $this->field(true)->where("userid = $uid and gid = '$gid'")->order("gsid desc")->select()->toArray();
        return $res;
    }

    /**
     * 通过用户ID 和 游戏服务器ID 获取服务器信息
     * @param  [type] $uid  [description]
     * @param  [type] $gsid [description]
     * @return [type]       [description]
     */
    public function getServerInfoByUidGsid($uid,$gsid) {
        $res = $this->field(true)->where("userid = $uid and gsid = $gsid")->find();
        return $res;
    }
}
