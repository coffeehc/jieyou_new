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
function getGameNameById($gid) {
    $result = model('game')->field('name')->find($gid);
    return $result['name'];
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
