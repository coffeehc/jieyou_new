<?php
namespace app\common\model;
use think\Model;

class Adimg extends Model {

    /**
     * 获取banner 图
     * @return [type] [description]
     */
    public function getBannerImg() {
        $res = $this
                ->field('id,gid,banner_img,tj')
                ->where("FIND_IN_SET('2',tj) AND banner_img <> ('')")
                ->select();
        return $res;
    }

    /**
     * 获取首页精品推荐的4个图
     * @return [type] [description]
     */
    public function getJingpingImg() {
        $res = $this
                ->field('id,gid,tj,jingping_img')
                ->where("FIND_IN_SET('1',tj) AND jingping_img <> ('')")
                ->order('rand()')
                ->limit(4)
                ->select();
        return $res;
    }

    /**
     * 首页中部广告
     * @return [type] [description]
     */
    public function getZhongbuImg() {
        $res = $this
                ->field('id,gid,tj,zhongbu_img')
                ->where("FIND_IN_SET('3',tj) AND zhongbu_img <> ('')")
                ->order('update_time desc')
                ->find();
        return $res;
    }

    /**
     * 获取首页底部广告
     * @return [type] [description]
     */
    public function getDibuImg() {
        $res = $this
                ->field('id,gid,tj,dibu_img')
                ->where("FIND_IN_SET('4',tj) AND dibu_img <> ('')")
                ->order('update_time desc')
                ->limit(2)
                ->select();
        return $res;
    }

    /**
     * 获取首页右上广告
     * @return [type] [description]
     */
    public function getYoushangImg() {
        $res = $this
                ->field('id,gid,tj,youshang_img')
                ->where("FIND_IN_SET('5',tj) AND youshang_img <> ('')")
                ->order('update_time desc')
                ->find();
        return $res;
    }

    /**
     * 获取首页右下广告
     * @return [type] [description]
     */
    public function getYouxiaImg() {
        $res = $this
                ->field('id,gid,tj,youxia_img')
                ->where("FIND_IN_SET('6',tj) AND youxia_img <> ('')")
                ->order('update_time desc')
                ->find();
        return $res;
    }
}
