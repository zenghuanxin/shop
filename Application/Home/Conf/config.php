<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4 0004
 * Time: 18:26
 */
return array(
    'HTML_CACHE_ON'     =>    false, // 开启静态缓存
    'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.html', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
        // 定义格式1 数组方式
        'Index:index'    =>     array('index', 3600),
        //设置商品详情页缓存
        'Index:goods'    =>     array('{goods_id|goodsdir}/goods_{goods_id}',3600)
    )
);

function goodsdir($goods_id){

    return ceil($goods_id/100);
}