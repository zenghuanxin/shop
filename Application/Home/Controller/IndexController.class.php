<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){

        $goodsModel = D('Admin/Goods');
        $crazygoods = $goodsModel->getCrazyGoods();
        $hotgoods = $goodsModel->getHotGoods();
        $bestgoods = $goodsModel->getBestGoods();
        $newgoods = $goodsModel->getNewGoods();
        $this->assign(array(
            'crazygoods'=>$crazygoods,
            'hotgoods'=>$hotgoods,
            'bestgoods'=>$bestgoods,
            'newgoods'=>$newgoods,
        ));
        $this->setPageInfo('首頁','商城','商城實戰','1',array('index'),array('index'));
        $this->display();
    }
}