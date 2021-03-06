<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  咨询管理
 */
class Article extends BaseController {
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
        if(request()->isPost()) {
            $data = input('post.');
            try{
                $id = $this->_db->addData($data);
                if($id) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            }catch(\Exception $e) {
                return show(0,$e->getMessage());
            }

        }else {
            $game = model('Game')->getGameInfo();
            if(input('param.type') == 1) {
                $articleClass = [4=>'游戏资料'];
            }else {
                $articleClass = config('article.article_class');
            }
            return $this->fetch('',[
                'game' => $game,
                'articleClass' => $articleClass,
            ]);
        }
    }

    /**
     * 编辑
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function edit($id=0) {
        $article = $this->_db->get($id);
        $game = model('Game')->getGameInfo();
        $articleClass = config('article.article_class');
        return $this->fetch('',[
            'game' => $game,
            'articleClass' => $articleClass,
            'article' => $article,
        ]);
    }

    /**
     * 更新数据操作
     * @return [type] [description]
     */
    public function update() {
        $data = input('post.');
        if(!$data['tj']) {
            $data['tj'] = 0;
        }
        if(!request()->isPost()) {
            return show(0,'请求错误');
        }
        try{
            $res = $this->_db->save($data,['id'=>intval($data['id'])]);
            if($res) {
                return show(1,'更新成功');
            }else {
                return show(0,'更新失败');
            }
        }catch(\Exception $e) {
            return show(0,$e->getMessage());
        }
    }
}
