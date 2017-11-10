<?php
namespace app\common\model;
use think\Model;

class Article extends BaseModel {

    public $cid = 4;
    protected $autoWriteTimestamp = true;
    /**
     * 咨询信息
     * @param   array  $data [查询条件]
     * @return [type]       [description]
     */
    public function getArticleInfo($data=[]) {
        $order = [
            'id' => 'desc',
        ];

        $result = $this
                    ->where($data)
                    ->order($order)
                    ->select();
        return $result;
    }

    /**
     * 获取条数
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function getArticleInfoCount($data=[]) {

        $result = $this
                    ->where($data)
                    ->count();
        return $result;
    }

    public function addData($data) {
        $res = $this->save($data);
        return $res;
    }

    /**
     * 获取首页游戏公报
     * @return [type] [description]
     */
    public function getGameArticle() {
        $res = $this   
                ->field('id,title,create_time')
                ->order('create_time desc')
                ->where('cid <>'.$this->cid)
                ->limit(8)
                ->select();
        return $res;
    }

    /**
     * 获取状态为1的资讯
     * @return [type] [description]
     */
    public function getNormalArticle() {
        $res = $this
                ->field(true)
                ->order('create_time desc')
                ->where('status = 1 and cid <>'.$this->cid)
                ->paginate(15);
        return $res;
    }

    /**
     * 通过游戏ID 获取游戏的资讯
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getGameArticleByGid($id) {
        $res = $this
                ->field('title,id,gid')
                ->order('update_time desc')
                ->where('status = 1 and gid = '.$id.' and cid <>'.$this->cid)
                ->limit(10)
                ->select();
        return $res;
    }

    /**
     * 获取游戏 资料 cid == 4
     */
    public function getGameZlByGid($id) {
        $res = $this
            ->field('title,id,gid')
            ->where('status = 1 and gid = '.$id.' and cid ='.$this->cid)
            ->select();
        return $res;
    }
}
