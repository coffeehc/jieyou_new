<?php
namespace app\index\controller;
use think\Controller;

class Pay extends User {

    /**
     * 充值页面
     * @return [type] [description]
     */
    public function index() {
        $serverId = input('param.id');
        // 获取服务器信息
        $serverInfo = model('GameServer')->getGameServerByid($serverId);
        $user = $this->getLoginUser();
        // 获取充值方式信息
        $payWays = model('Payfs')->getPayfsInfo();

        return $this->fetch('',[
            'serverInfo' => $serverInfo,
            'payWays' => $payWays,
        ]);
    }
}
