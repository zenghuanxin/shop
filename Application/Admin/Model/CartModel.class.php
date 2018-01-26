<?php
namespace Admin\Model;
use Think\Model;
class CartModel extends Model
{
    public function addToCart($goods_id,$goods_attr_id,$goods_number=1){

        $mid = session('mid');
        if ($mid){

            //先查看数据库中是否有数据
            $cartModel = M('Cart');
            $has = $cartModel->where(array('goods_id'=>$goods_id,'goods_attr_id'=>$goods_attr_id,'member_id'=>$mid))->find();

            if ($has){
                $cartModel->where(array('id'=>$has['id']))->setInc('goods_number',$goods_number);
            }else{
                $cartModel->add(array(
                    'goods_id'=>$goods_id,
                    'goods_attr_id'=>$goods_attr_id,
                    'member_id'=>$mid,
                    'goods_number'=>$goods_number,
                ));
            }

        }else{
            //先取出cookie中的数据
            $cart = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']):array();
            //把商品加入到这个数组中
            $key = $goods_id.'-'.$goods_attr_id;
            if (isset($cart[$key])){
                $cart[$key] += $goods_number;
            }else{
                $cart[$key] = $goods_number;
            }

            $partime = 30*84600;
            setcookie('cart',serialize($cart),time()+$partime,'/','shop.com');
        }

    }

    public function cartList(){

        $mid = session('mid');
        if ($mid){
            //先查看数据库中是否有数据
            $cartModel = M('Cart');
            $_cart = $cartModel->where(array('member_id'=>$mid))->select();

        }else{
            //先取出cookie中的数据
            //转换这个一维数组的结构和从数据库中取出的数组结构一样，都是二维数组
            $_cart_ = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']):array();
            $_cart =array();
            foreach ($_cart_ as $k=>$v){
                //从下表解析出商品ID 和商品属性ID
                $_k = explode('-',$k);
                $_cart[] = array(
                    'goods_id'=>$_k[0],
                    'goods_attr_id'=>$_k[1],
                    'goods_number'=>$v,
                    'member_id'=>0,
                );
            }
        }
        /*****************循环购物车中的每件商品,根据ID取出商品信息*********************/
        $goodsModel = D('Admin/goods');
        foreach ($_cart as $k => $v){
            $ginfo = $goodsModel->field('sm_logo,goods_name')->find($v['goods_id']);
            $_cart[$k]['goods_name'] = $ginfo['goods_name'];
            $_cart[$k]['sm_logo'] = $ginfo['sm_logo'];
            //计算会员价格
            $_cart[$k]['price'] = $goodsModel->getMemberPrice($v['goods_id']);
            //把商品属性ID转化成商品属性字符串
            $_cart[$k]['goods_attr_str'] = $goodsModel->convertGoodsAttrIdToGoodsAttrStr($v['goods_attr_id']);
        }
        return $_cart;
    }

    public function dataToDb()
    {
        $mid = session('mid');
        if ($mid){
            //先从cookie取出数据
            $_cart = isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']):array();
            if ($_cart){
                foreach ($_cart as $k=>$v){
                    $_k = explode('-',$k);
                    $this->addToCart($_k[0],$_k[1],$v);
                }
            }
        }
        setcookie('cart','',time()-1,'/','shop.com');
    }

    public function updateData($gid, $gaid, $gn)
    {
        $mid = session('mid');
        if($mid)
        {
            $cartModel = M('Cart');
            if($gn == 0)
                $cartModel->where(array(
                    'goods_id' => array('eq', $gid),
                    'goods_attr_id' => array('eq', $gaid),
                    'member_id' => array('eq', $mid),
                ))->delete();
            else
                $cartModel->where(array(
                    'goods_id' => array('eq', $gid),
                    'goods_attr_id' => array('eq', $gaid),
                    'member_id' => array('eq', $mid),
                ))->setField('goods_number', $gn);
        }
        else
        {
            // 先从COOKIE中取出购物车的数组
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            $key = $gid . '-' . $gaid;
            if($gn == 0)
                unset($cart[$key]);
            else
                $cart[$key] = $gn;
            // 把这个数组存回到cookie
            $aMonth = 30 * 86400;
            setcookie('cart', serialize($cart), time() + $aMonth, '/', '34.com');
        }
    }

    //清空购物车
    public function clear(){

        $mid = session('mid');
        if ($mid){
            //取出勾选的商品
            $buythis = session('buythis');
            foreach ($buythis as $k=>$v){
                //从字符串解析出商品ID和属性ID
                $_v = explode('-',$v);
                $this->where(array('member_id'=>$mid,'goods_id'=>$_v['0'],'goods_attr_id'=>$_v[1]))->delete();
            }
        }else{
            setcookie('cart','',time()-1,'/','shop.com');
        }
    }


}