<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model
{
	protected $insertFields = array('shr_name','shr_province','shr_city','shr_area','shr_address','shr_tel','post_method','pay_method');

	protected $_validate = array(
        array('shr_name', 'require', '收货人姓名不能为空！', 1),
        array('shr_province', 'require', '收货人所在省不能为空！', 1),
        array('shr_city', 'require', '收货人所在市不能为空！', 1),
        array('shr_area', 'require', '收货人所在地区不能为空！', 1),
        array('shr_address', 'require', '收货人所在详细地址不能为空！', 1),
        array('shr_tel', 'require', '收货人电话不能为空！', 1),
        array('post_method', 'require', '发货方式不能为空！', 1),
        array('pay_method', 'require', '支付方式不能为空！', 1),
	);

	// 添加前
	protected function _before_insert(&$data, $option)
	{
	    //判断购物车中是否有商品

        $cartModel = D('Admin/Cart');
        $cartdata = $cartModel->cartList();
        if (count($cartdata) == 0){

            $this->error = '购物车中必须有商品才能下单';
            return false;
        }
        //循环购物车中每件商品检查库存量够不够，并且计算总价
        //加锁-》高并发下单时，库存量会出现混乱的问题，加锁来解决

        $this->fp = fopen('./order.lock','r');
        flock($this->fp,LOCK_EX);
        $tp = 0;
        $gnModel = D('Admin/GoodsNumber');
        $buythis = session('buythis');
        foreach ($cartdata as $k=>$v){

            //判断这件商品有没有被选中
            if (!in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis)){
                continue;
            }
            //取出商品的库存量
            $gn = $gnModel->field('goods_number')->where(
                array('goods_id'=>$v['goods_id'],'goods_attr_id'=>$v['goods_attr_id'])
            )->find();

            if ($gn['goods_number'] <$v['goods_number']){

                $this->error = '商品库存量不足无法下单';
                return false;
            }

            $tp +=$v['goods_number']* $v['price'];
        }
        //下单前把订单的其他信息补充即刻
        $data['member_id'] = session('mid');
        $data['addtime'] = time();
        $data['total_price'] = $tp;
        //启动事务
        mysql_query('START TRANSACTION');
	}

	protected function _after_insert($data, $options)
    {

        //处理订单商品表
        //把购物车中的数据存到订单商品表
        $cartModel = D('Admin/Cart');
        $cartdata = $cartModel->cartList();
        //循环购物车中的每件商品:1：减少库存量,2：插入订单商品表
        $ogModel = M('OrderGoods');
        $gnModel = M('GoodsNumber');
        $buythis = session('buythis');
        foreach ($cartdata as $v){

            //如果这件商品没有勾选就不处理库存量
            if (!in_array($v['goods_id'].'-'.$v['goods_attr_id'],$buythis)){
                continue;
            }
            //循环购物车中的每件商品减少库存量
            $gn = $gnModel->where(
                array('goods_id'=>$v['goods_id'],'goods_attr_id'=>$v['goods_attr_id'])
            )->setDec('goods_number',$v['goods_number']);
            if ($gn === false){
                mysql_query('ROLLBACK');
                return false;
            }
            //插入到订单商品表
            $rs = $ogModel->add(array(
                'order_id'=>$data['id'],
                'member_id'=>session('mid'),
                'goods_id'=>$v['goods_id'],
                'goods_attr_id'=>$v['goods_attr_id'],
                'goods_attr_str'=>$v['goods_attr_str'],
                'goods_price'=>$v['price'],
                'goods_number'=>$v['goods_number'],
            ));
            if ($rs === false){
                mysql_query('ROLLBACK');
                return false;
            }
        }
        //提交事务
        mysql_query('COMMIT');
        //释放锁
        flock($this->fp,LOCK_UN);
        fclose($this->fp);
        //清空购物车中选中的商品
        $cartModel->clear();
        session('buythis',null);
    }

    //设置订单为已支付的状态
    public function setPaid($id){
	    //更新订单的状态为已支付的状态
        $this->where(array('id'=>$id))->setField('pay_status',1);
        //增加会员的经验值和积分 - 订单的总价是多少就加多少经验值和积分
        $info = $this->field('total_price,member_id')->find($id);
        $this->execute('update shop_member set jyz=jyz+'.$info['total_price'].',jifen=jifen+'.$info['total_price'].'where id='.$info['member_id']);
    }


}