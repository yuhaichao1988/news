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

function pagination($obj){
    if (!$obj) {
        return '';
    }
    $params = request()->param();
    return '<div class="imooc-app">'.$obj->appends($params)->render().'</div>';

}

/**
 * 获取分类栏目名称
 * @param $catid
 * @return string
 */
function getCatName($catid){
    if (!$catid) {
        return '';
    }
    $cats = config('cat.lists');
    return !empty($cats[$catid]) ? $cats[$catid] : '';
}

function isYesNo($str) {
    return $str ?  '<span style="color: red"> 是 </span>' : '<span > 否 </span>';
}

function status($id, $status){
    $controller = request()->controller();
    $sta = $status == 1 ? 0 : 1;
    $url = url($controller.'/status',['id' => $id, 'status' => $sta]);
    if ($status == 1){
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-success radius'>正常</span></a>";
    }elseif ($status == 0){
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='app_status(this)'><span class='label label-danger '>待审</span></a>";
    }
    return $str;
}

/**
 * 通用化API接口数据输出
 * @param int $status 业务状态码
 * @param string $message 提示信息
 * @param array $data 返回数据
 * @param int $httpCode HTTP状态码
 * @return array
 */
function show($status, $message, $data = [], $httpCode = 200){

    $restul = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ];

    return  json($restul,$httpCode);
}

