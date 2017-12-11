<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/6 0006
 * Time: 10:20
 */
function removeXSS($val){

    //实现一个单例模式，这个函数调用多次时只有第一次调用时生成一个对象之后在调用使用的是第一次生成的对象
    //（只生成一个对象），使性能更好
    static $obj = null;
    if ($obj === null){

        require ('./HTMLPurifier/HTMLPurifier.includes.php');
        $config = HTMLPurifier_Config::createDefault();
        //保留a标签上的target属性
        $config->set('HTML.TargetBlank',TRUE);
        $obj = new HTMLPurifier($config);
    }
    return $obj->purify($val);
}

function setPageBtn($pagetitle,$pagebtn,$pageurl){
    $this->assign('pagetitle',$pagetitle);
    $this->assign('pagebtn',$pagebtn);
    $this->assign('pageurl',$pageurl);
}