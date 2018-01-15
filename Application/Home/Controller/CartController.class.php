<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CartController extends BaseController {
    public function add(){

        $cartModel = D('Admin/Cart');
        $goodsAttrId = I('post.goods_attr_id');
        if ($goodsAttrId){

            //升序排列，以便和后台的库存量对应，免得出现数据错误
            sort($goodsAttrId);
            $goodsAttrId = implode(',',$goodsAttrId);
        }
        $cartModel->addToCart(I('post.goods_id'),$goodsAttrId,I('post.amount'));
        redirect(U('lst','',false));
    }
    public function lst(){

        $cartModel = D('Admin/Cart');
        $data = $cartModel->cartList();
        $this->assign('data',$data);
        $this->setPageInfo('购物车','购物车','购物车','1',array('cart'),array('cart1'));
        $this->display();
    }


}