<?php
namespace app\index\controller;
use think\Controller;

class BaseController extends Controller {

    public function _initialize() {
        // 配置信息
        $config = model('Config')->getConfigInfo();
        $this->assign('config',$config);

        // banner 图
        $banner = model('Adimg')->getBannerImg();
        $this->assign('banner',$banner);
    }
}
