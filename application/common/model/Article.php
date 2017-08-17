<?php
namespace app\common\model;
use think\Model;

class Article extends Model {

    /**
     * 咨询信息
     * @param   array  $data [查询条件]
     * @return [type]       [description]
     */
    public function getArticleInfo($data=[]) {
        $data['status'] = 1;
        $order = [
            'id' => 'desc',
        ];

        $result = $this
                    ->where($data)
                    ->order($order)
                    ->select();
        $result['count'] = $this
                            ->where($data)
                            ->order($order)
                            ->count();
        return $result;
    }
}
