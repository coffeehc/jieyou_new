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
        $articles = $this->_db->getArticleInfo();
        return $this->fetch('',[
            'articles' => $articles,
        ]);
    }

    /**
     * 添加咨询
     */
    public function add() {
        return $this->fetch();
    }
}
