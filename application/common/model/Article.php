<?php
namespace app\common\model;
use think\Model;

class Article extends BaseModel {

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
}
