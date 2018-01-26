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

        $buythis = I('post.buythis');

        if (!$buythis){
            if (!session('buythis')){
                $this->error('必须选中一个商品才能结算');
            }
        }else{
            session('buythis',$buythis);
        }
        $mid = session('mid');
        //如果会员没有登录，跳到登录页面，登录成功后跳到订单页面
        if (!$mid){
            //把当前的页面地址存到session中，登录之后才能调回下订单页面
            session('returnUrl',U('order'));
            redirect(U('Home/Member/login'));
        }
        //如果是下单的表单才处理
        if (IS_POST && !isset($_POST['buythis'])){

            $orderModel = D('Admin/Order');
            if ($orderModel->create(I('post.'),1)){

                if ($order_id = $orderModel->add()){

                    $this->success('下单成功',U("order_ok?order_id=$order_id"));
                    exit();
                }
            }
            $this->error($orderModel->getError());
        }

        //先取出购物车中的商品
        $cartModel = D('Admin/Cart');
        $data = $cartModel->cartList();
        $orderdata = array();
        foreach ($data as $k=>$v){
            if (in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis)){
                $orderdata[] = $v;
            }
        }
        //如果会员登录了就显示表单

        $this->assign('data',$orderdata);
        $this->setPageInfo('下订单','下订单','下订单','1',array('fillin'),array('cart2'));
        $this->display();

    }
    //接收支付宝发过来的消息
    public function respond(){

        //调用notify_url.php文件中的代码
        include('./alipay/notify_url.php');
    }

    public function success()
    {
        echo '支付成功!';
    }

    public function order_ok(){

        $id = I('get.order_id');
        $orderModel = M('Order');
        $tp = $orderModel->field('total_price')->find($id);
        /**********生成支付宝按钮**************/
        require_once("./alipay/alipay.config.php");
        require_once("./alipay/lib/alipay_submit.class.php");

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径 - 我们用来接受支付宝发来的消息的地址
        $notify_url = "http://www.shop.com/index.php/Home/Cart/respond";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径 - 会员在支付宝支付成功之后跳转到哪个页面
        $return_url = "http://www.shop.com/index.php/Home/Cart/success";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户 - 收钱账号
        $seller_email = '18659328891@163.com';
        //必填

        //商户订单号 - 本地的订单号->这次支付对应的本地的哪个订单
        $out_trade_no = $id;
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = 'shop.com订单支付';
        //必填

        //付款金额
        $total_fee = $tp['total_price'];
        //必填

        //订单描述

        $body = 'shop.com订单支付';
        //商品展示地址 - 购买的商品的详细页面的地址 -》订单中所有商品的详情页面
        //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1

        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "seller_email"	=> $seller_email,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        //生成按钮的html代码
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "去支付宝支付");
        $this->assign('button',$html_text);
        $this->setPageInfo('下单成功','下单成功','下单成功','1',array('success'));
        $this->display();

    }


}