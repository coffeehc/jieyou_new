<?php
namespace app\admin\controller;
use think\Controller;

/**
 *  后台首页
 */
class Index extends BaseController{

    public function index() {
        $manager = $this->getLoginUser();
        return $this->fetch('',[
            'manager' => $manager,
        ]);
    }

    public function welcome() {
        $manager = $this->getLoginUser();
        // 游戏数量
        $gameCount = model('Game')->getGameCount();
        // 服务器数量
        $serverCount = model('GameServer')->getGameserverCount();
        // 已经开区服务器
        $serverOpenedCount = model('GameServer')->getGameserverOpenedCount();
        // 即将开区服务器
        $serverOpenCount = model('GameServer')->getGameserverOpenCount();
        // 玩家注册数量
        $playerRegCount = model('User')->getPlayerRegCount();
        // 支付成功金额
        $paySuccessMoney = model('UserPay')->getPaySuccessMoney();
        // 未支付成功金额
        $payErrorMoney = model('UserPay')->getPayErrorMoney();
        // 网站咨询
        $articleCount = model('Article')->getArticleInfoCount();
        return $this->fetch('',[
            'manager' => $manager,
            'game' => $gameCount,
            'server' => $serverCount,
            'serveropened' => $serverOpenedCount,
            'serveropen' => $serverOpenCount,
            'player' => $playerRegCount,
            'paysuccess' => $paySuccessMoney,
            'payerror' => $payErrorMoney,
            'article' => $articleCount,
        ]);
    }
}
