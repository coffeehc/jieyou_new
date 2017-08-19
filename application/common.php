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
            $str = '<span class="label label-success radius">已发布</span>';
            break;
        case 0:
            $str = '<span class="label label-defaunt radius">已下架</span>';
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
            $str = '<a style="text-decoration:none" onClick="article_start(this,'.$id.',1)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>';
            break;
        case 1:
            $str = '<a style="text-decoration:none" onClick="article_stop(this,'.$id.',0)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>';
        default:
            break;
    }
    return $str;
}
