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

    public function goods(){

        $goods_id = I('get.goods_id');
        // 取出商品的基本信息
        $goodsModel = M('Goods');
        $goodsinfo = $goodsModel->field('a.*,b.brand_name')->alias('a')->join('left join shop_brand b on b.id=a.brand_id')->where(array('a.id'=>$goods_id))->find();

        // 取出商品的单选属性
        $gattr1=array();
        $attrmodel = M('Attribute');
        $goodsAttr1 = $attrmodel->field('b.*,a.attr_name,a.attr_option_values')->alias('a')->join('left join shop_goods_attr b on a.id = b.attr_id')->where(array('b.goods_id'=>$goods_id,'a.attr_type'=>array('eq',1)))->select();
        foreach ($goodsAttr1 as $v){
            $gattr1[$v['attr_name']][] = $v;
        }

        // 取出商品的图片信息
        $imgModel = M('GoodsPics');
        $goodsimgs = $imgModel->where(array('goods_id'=>$goods_id))->select();

        // 取出商品的唯一属性
        $gattr2 = $attrmodel->field('b.*,a.attr_name,a.attr_option_values')->alias('a')->join('left join shop_goods_attr b on a.id = b.attr_id')->where(array('b.goods_id'=>$goods_id,'a.attr_type'=>array('eq',0)))->select();
        $this->assign(array(
            'goodsinfo'=>$goodsinfo,
            'gattr1'=>$gattr1,
            'gattr2'=>$gattr2,
            'goodsimgs'=>$goodsimgs,
        ));

        // 设置页面的信息
        $this->setPageInfo($goodsinfo['goods_name'] . '-商品详情页', $goodsinfo['seo_keyword'], $goodsinfo['seo_description'], 0, array('goods','common','jqzoom'), array('goods','jqzoom-core'));
        // 显示页面
        $this->display();
    }

}