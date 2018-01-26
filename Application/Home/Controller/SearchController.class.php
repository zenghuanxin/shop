<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class SearchController extends BaseController {
    public function search(){

        $this->setPageInfo('搜索页面', '搜索页面', '搜索页面',0, array('list','common'), array('list'));
        // 显示页面
        $this->display();
    }



}