<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  咨询管理
 */
class Article extends Controller {

    private $_db;
    public function _initialize() {
        $this->_db = model('Article');
    }
    /**
     * 咨询列表页
     * @return [type] [description]
     */
    public function index() {
        $data = input('get.');
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])) {
            $sdata['creat_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['cid'])){
            $sdata['cid'] = $data['cid'];
        }
        if(!empty($data['title'])) {
            $sdata['title'] = ['like','%'.$data['title'].'%'];
        }
        $articles = $this->_db->getArticleInfo($sdata);
        $count = $this->_db->getArticleInfoCount();
        return $this->fetch('',[
            'articles' => $articles,
            'count' => $count,
            'cid' => empty($data['cid'])?'':$data['cid'],
            'start_time' => empty($data['start_time'])?'':$data['start_time'],
            'end_time' => empty($data['end_time'])?'':$data['end_time'],
            'title' => empty($data['title'])?'':$data['title'],
        ]);
    }

    /**
     * 添加咨询
     */
    public function add() {
        return $this->fetch();
    }
}
