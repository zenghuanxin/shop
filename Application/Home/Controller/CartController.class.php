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
//        dump($data);die();
        $this->assign('data',$data);
        $this->setPageInfo('购物车','购物车','购物车','1',array('cart'),array('cart1'));
        $this->display();
    }

    public function ajaxUpdateData(){
        $gid = I('get.gid');
        $gaid = I('get.gaid','');
        $gn = I('get.gn');
        $cartModel = D('Admin/Cart');
        $cartModel->updateData($gid,$gaid,$gn);
    }

    public function order(){

        $mid = session('mid');
        //如果会员没有登录，跳到登录页面，登录成功后跳到订单页面
        if (!$mid){
            //把当前的页面地址存到session中，登录之后才能调回下订单页面
            session('returnUrl',U('order'));
            redirect(U('Home/Member/login'));
        }

        if (IS_POST){

            $orderModel = D('Admin/Order');
            if ($orderModel->create(I('post.'),1)){

                if ($orderModel->add()){

                    $this->success('下单成功',U('order_ok'));
                    exit();
                }
            }
            $this->error($orderModel->getError());
        }

        //先取出购物车中的商品
        $cartModel = D('Admin/Cart');
        $data = $cartModel->cartList();
        //如果会员登录了就显示表单

        $this->assign('data',$data);
        $this->setPageInfo('下订单','下订单','下订单','1',array('fillin'),array('cart2'));
        $this->display();

    }


}