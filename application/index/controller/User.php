<?php
namespace app\index\controller;
use think\Controller;

class User extends BaseController {
    /**
     * 初始化 判断用户是否登录
     * @return [type] [description]
     */
    public function _initialize() {
        parent::_initialize();
        $isLogin = $this->userIsLogin();
        if(!$isLogin) {
            return $this->error('你还没有登录哦，请先登录','index/index');
        }
    }

    /**
     * 玩家中心首页
     * @return [type] [description]
     */
    public function index() {
        $user = $this->getLoginUser();
        // 最近五笔充值记录
        $userPay = model('UserPay')->getUserPayByUid($user['id'],5);
        return $this->fetch('',[
            'userPay' => $userPay,
        ]);
    }

    /**
     * 用户详细资料
     * @return [type] [description]
     */
    public function userInfo() {
        return $this->fetch();
    }

    /**
     * 玩过的游戏
     * @return [type] [description]
     */
    public function playedGame() {
        $user = $this->getLoginUser();
        $playedGames = model('UserServer')->getPlayedGameByUid($user['id']);
        return $this->fetch('',[
            'playedGames' => $playedGames,
        ]);
    }

    /**
     * 充值记录
     * @return [type] [description]
     */
    public function payInfo() {
        $user = $this->getLoginUser();
        $payInfos = model('UserPay')->getUserPayInfoByUid($user['id']);
        return $this->fetch('',[
            'payInfos' => $payInfos,
        ]);
    }

    /**
     * CPS推广中心 推广链接
     * @return [type] [description]
     */
    public function cpsUrl() {
        return $this->fetch();
    }

    /**
     * 我的推广成果
     * @return [type] [description]
     */
    public function cpsUser() {
        $user = $this->getLoginUser();
        $cpsUsers = model('User')->getCpsUserInfoByUid($user['id']);
        return $this->fetch('',[
            'cpsUsers' => $cpsUsers,
        ]);
    }

    /**
     * 玩家充值
     * @return [type] [description]
     */
    public function cpsPay() {
        $user = $this->getLoginUser();
        $cpsPays = model('UserPay')->getCpsPayInfoByUid($user['id']);
        return $this->fetch('',[
            'cpsPays' => $cpsPays,
        ]);
    }
}
