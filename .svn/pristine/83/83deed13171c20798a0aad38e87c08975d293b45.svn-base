<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 *对输入过滤
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function hc_filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}

function show($code,$message='',$data=[]) {
    return [
        'code' => intval($code),
        'message' => $message,
        'data' => $data,
    ];
}

/**
 * 获取资讯类型
 * @param  [type] $cid [description]
 * @return [type]      [description]
 */
function getArticleClassName($cid) {
    $name = '';
    switch ($cid) {
        case 1:
            $name = '游戏资讯';
            break;
        case 2:
            $name = '网站资讯';
            break;
        case 3:
            $name = '玩家资讯';
            break;
        default:
            $name = '其他';
            break;
    }
    return $name;
}
/**
 * 通过ID获取游戏名称
 * @param  [type] $gid [description]
 * @return [type]      [description]
 */
function getGameNameById($id) {
    $result = model('game')->field('name')->find($id);
    return $result['name'];
}

/**
 * 通过游戏 GID 获取游戏名称
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function getGameNameByGid($str) {
    $res = model('game')->field('name')->where('gid',$str)->find();
    return $res['name'];
}

/**
 * 通过游戏类型ID 获取游戏名字
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function gameByType($id) {
    $res = model('game')->field('name,id,gid')->where('lxid='.$id)->select();
    return $res;
}

function status($status) {
    $str = '';
    switch ($status) {
        case 1:
            $str = '<span class="label label-success radius">已启用</span>';
            break;
        case 0:
            $str = '<span class="label label-defaunt radius">已禁用</span>';
            break;
        default:
            $str = '<span class="label label-defaunt radius">其他</span>';
            break;
    }
    return $str;
}

function upOrDown($status,$id) {
    $str = '';
    switch ($status) {
        case 0:
            $str = '<a style="text-decoration:none" onClick="hecheng_start(this,'.$id.',1)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe615;</i></a>';
            break;
        case 1:
            $str = '<a style="text-decoration:none" onClick="hecheng_stop(this,'.$id.',0)" href="javascript:;" title="禁用"><i class="Hui-iconfont">&#xe631;</i></a>';
        default:
            break;
    }
    return $str;
}

function getAuthName($auth) {
    $str = '';
    switch ($auth) {
        case '*':
            $str = '管理员';
            break;
        case '10':
            $str = '平台用户';
            break;
        default:
            # code...
            break;
    }
    return $str;
}

function getLinkClassName($class) {
    $str = '';
    switch ($class) {
        case 0:
            $str = '文字链接';
            break;
        case 1:
            $str = '图片链接';
            break;
        default:
            # code...
            break;
    }
    return $str;
}

function changeTimeToStr($time) {
    if($time == '1970-01-01 08:00:00') {
        return '最近没有登录过';
    }else {
        return $time;
    }
}

function changeTimeToStrForPay($time) {
    if($time == '1970-01-01 08:00:00') {
        return '';
    }else {
        return $time;
    }
}

function getStatusByQx($qx) {
    $str = '';
    switch ($qx) {
        case 1:
            $str = '<span class="label label-success radius">支付成功</span>';
            break;
        case 0:
            $str = '<span class="label label-default radius">未支付</span>';
            break;
        default:
            break;
    }
    return $str;
}

function registerOrNo($qx) {
    $str = '';
    switch ($qx) {
        case 1:
            $str = '<span class="label label-success radius">已注册</span>';
            break;
        case 0:
            $str = '<span class="label label-default radius">未注册</span>';
            break;
        default:
            break;
    }
    return $str;
}

function showOrHidden($qx) {
    $str = '';
    switch ($qx) {
        case 1:
            $str = '<span class="label label-success radius">显示</span>';
            break;
        case 0:
            $str = '<span class="label label-default radius">不显示</span>';
        default:
            # code...
            break;
    }
    return $str;
}

/**
 * 通过用户ID 获取到自己充值成功的money
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getMoneyById($id) {
    $res = model('UserPay')->field('sum(money) as money')->where('qx = 1 and uid = '.$id)->find();
    $str = '';
    if($res['money'] > 0) {
        $str = '<span class="label label-warning radius">￥'.$res['money'].'.00</span>';
    }else {
        $str = '<span class="label label-default radius">￥0.00</span>';
    }
    return $str;
}

/**
 * 通过用户ID 获取推荐人数
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getTjNumById($id) {
    $res = model('User')->field('count(id) as num')->where('tjrid='.$id)->find();
    $str = '';
    if($res['num'] > 0) {
        $str = '<span class="label label-warning radius">'.$res['num'].'</span>';
    }else {
        $str = '<span class="label label-default radius">0</span>';
    }
    return $str;
}

/**
 * 通过用户ID 获取佣金
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getCpsMoneyById($id) {
    $res = model('User')->query('select sum(a.money) as money from jy_user_pay as a,jy_user as b where a.uid = b.id and b.tjrid = '.$id.' and a.qx = 1');
    $cps = model('Config')->field('cps')->find();
    foreach ($res as $key => $value) {
        $money = $value['money'];
    }
    $money = number_format($money*$cps['cps']/100,2);
    if($money > 0) {
        $str = '<span class="label label-warning radius">￥'.$money.'</span>';
    }else {
        $str = '<span class="label label-default radius">￥0.00</span>';
    }
    return $str;
}

/**
 * 通过游戏GID获取服务器数量
 * @param  [type] $gid [description]
 * @return [type]      [description]
 */
function getServerNumByGid($gid) {
    $res = model('GameServer')->where('gid='."'$gid'")->count();
    return $res;
}

/**
 * 通过PTID获取平台名称
 * @param  [type] $ptid [description]
 * @return [type]       [description]
 */
function getGamePtNameByPtid($ptid) {
    $res = model('Apikey')->field('name')->where('id='.$ptid)->find();
    return $res['name'];
}

/**
 * 通过LXID获取类型名称
 * @param  [type] $lxid [description]
 * @return [type]       [description]
 */
function getGametypeNameByLxid($lxid) {
    $res = model('GameType')->field('name')->where('id='.$lxid)->find();
    return $res['name'];
}

/**
 * 推荐位名字
 * @param  [type] $tj [description]
 * @return [type]     [description]
 */
function getTjName($tj) {
    $arr = ['没有推荐','精品游戏推荐','首页banner','首页中部广告','首页底部广告','首页右上广告','首页右下广告'];
    $arr2 = ['0','1','2','3','4','5','6'];
    $res = str_replace($arr2,$arr,$tj);
    echo  $res;
}

/**
 * 根据Id 获取渠道名称
 * @param  [type] $tid [description]
 * @return [type]      [description]
 */
function getPayNameByTid($tid) {
    $res = model('PayType')->field('name')->find($tid);
    return $res['name'];
}

/**
 * 通过用户ID获取玩家最近玩过的4款游戏
 * @return [type] [description]
 */
function getUserGameByUid($id) {
    $res = model('UserServer')->field(true)->where('userid='.$id)->order('update_time desc')->limit(4)->select();
    return $res;
}

function getUserUsersById($id) {
    $res = model('User')->field('users')->find($id);
    return $res['users'];
}

/**
 * game_server 表 通过ID 获取游戏名字
 * @return [type] [description]
 */
function getGameByGsid($id) {
    $res = model('GameServer')->field('game')->group('game')->find($id);
    return $res['game'];
}

/**
 * 通过ID 获取服务器名字
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getNameByGsid($id) {
    $res = model('GameServer')->field('name')->find($id);
    return $res['game'];
}

/**
 * 通过支付方式ID 获取支付方式名称
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getBankNameById($id) {
    $res = model('Payfs')->field('name')->find($id);
    return $res['name'];
}
