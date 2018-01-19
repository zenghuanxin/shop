<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
    protected $insertFields = array('goods_name','cat_id','brand_id','market_price','shop_price','jifen','jyz','jifen_price','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc','is_promote');
    protected $updateFields = array('id','goods_name','cat_id','brand_id','market_price','shop_price','jifen','jyz','jifen_price','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','is_on_sale','seo_keyword','seo_description','type_id','sort_num','is_delete','goods_desc','is_promote');
    protected $_validate = array(
        array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
        array('goods_name', '1,45', '商品名称的值最长不能超过 45 个字符！', 1, 'length', 3),
        array('cat_id', 'require', '主分类的id不能为空！', 1, 'regex', 3),
        array('cat_id', 'number', '主分类的id必须是一个整数！', 1, 'regex', 3),
        array('brand_id', 'number', '品牌的id必须是一个整数！', 2, 'regex', 3),
        array('market_price', 'currency', '市场价必须是货币格式！', 2, 'regex', 3),
        array('shop_price', 'currency', '本店价必须是货币格式！', 2, 'regex', 3),
        array('jifen', 'require', '赠送积分不能为空！', 1, 'regex', 3),
        array('jifen', 'number', '赠送积分必须是一个整数！', 1, 'regex', 3),
        array('jyz', 'require', '赠送经验值不能为空！', 1, 'regex', 3),
        array('jyz', 'number', '赠送经验值必须是一个整数！', 1, 'regex', 3),
        array('jifen_price', 'require', '如果要用积分兑换，需要的积分数不能为空！', 1, 'regex', 3),
        array('jifen_price', 'number', '如果要用积分兑换，需要的积分数必须是一个整数！', 1, 'regex', 3),
        array('promote_price', 'currency', '促销价必须是货币格式！', 2, 'regex', 3),
        array('is_hot', 'number', '是否热卖必须是一个整数！', 2, 'regex', 3),
        array('is_new', 'number', '是否新品必须是一个整数！', 2, 'regex', 3),
        array('is_best', 'number', '是否精品必须是一个整数！', 2, 'regex', 3),
        array('is_on_sale', 'number', '是否上架：1：上架，0：下架必须是一个整数！', 2, 'regex', 3),
        array('seo_keyword', '1,150', 'seo优化_关键字的值最长不能超过 150 个字符！', 2, 'length', 3),
        array('seo_description', '1,150', 'seo优化_描述的值最长不能超过 150 个字符！', 2, 'length', 3),
        array('type_id', 'number', '商品类型id必须是一个整数！', 2, 'regex', 3),
        array('sort_num', 'number', '排序数字必须是一个整数！', 2, 'regex', 3),
        array('is_delete', 'number', '是否放到回收站：1：是，0：否必须是一个整数！', 2, 'regex', 3),
    );
	public function search($pageSize = 20,$isDelete = 0)
	{
		/**************************************** 搜索 ****************************************/
        // 是否是回收站的商品
        $where['is_delete'] = array('eq', $isDelete);
		if($goods_name = I('get.goods_name'))
			$where['goods_name'] = array('like', "%$goods_name%");
		if($cat_id = I('get.cat_id'))
			$where['cat_id'] = array('eq', $cat_id);
		if($brand_id = I('get.brand_id'))
			$where['brand_id'] = array('eq', $brand_id);
		$shop_pricefrom = I('get.shop_pricefrom');
		$shop_priceto = I('get.shop_priceto');
		if($shop_pricefrom && $shop_priceto)
			$where['shop_price'] = array('between', array($shop_pricefrom, $shop_priceto));
		elseif($shop_pricefrom)
			$where['shop_price'] = array('egt', $shop_pricefrom);
		elseif($shop_priceto)
			$where['shop_price'] = array('elt', $shop_priceto);
		$is_hot = I('get.is_hot');
		if($is_hot != '' && $is_hot != '-1')
			$where['is_hot'] = array('eq', $is_hot);
		$is_new = I('get.is_new');
		if($is_new != '' && $is_new != '-1')
			$where['is_new'] = array('eq', $is_new);
		$is_best = I('get.is_best');
		if($is_best != '' && $is_best != '-1')
			$where['is_best'] = array('eq', $is_best);
		$is_on_sale = I('get.is_on_sale');
		if($is_on_sale != '' && $is_on_sale != '-1')
			$where['is_on_sale'] = array('eq', $is_on_sale);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		$addtimefrom = I('get.addtimefrom');
		$addtimeto = I('get.addtimeto');
		if($addtimefrom && $addtimeto)
			$where['addtime'] = array('between', array(strtotime("$addtimefrom 00:00:00"), strtotime("$addtimeto 23:59:59")));
		elseif($addtimefrom)
			$where['addtime'] = array('egt', strtotime("$addtimefrom 00:00:00"));
		elseif($addtimeto)
			$where['addtime'] = array('elt', strtotime("$addtimeto 23:59:59"));
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->field('a.*,SUM(b.goods_number) num')->alias('a')->join('LEFT JOIN shop_goods_number b on a.id = b.goods_id')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{

	    $data['addtime'] = time();
        // 把促销时间转化成时间戳
        if($data['is_promote'] == 1)
        {
            $data['promote_start_time'] = strtotime($_POST['promote_start_time']);
            $data['promote_end_time'] = strtotime($_POST['promote_end_time']);
        }
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(150, 150, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
	}
	protected function _after_insert(&$data, $options)
    {
        /*************处理扩展分类表*************/
        $extcat = I('post.ext_cat_id');
        if ($extcat){
            $extcatModel = M('GoodsCat');
            foreach ($extcat as $k=>$v){
                if (empty($v))
                    continue;
                $extcatModel->add(array(
                    'goods_id'=>$data['id'],
                    'cat_id'=>$v
                ));
            }
        }
        /*************处理会员价格***********/
        $mp = I('post.mp');
        if ($mp){
            $mpModel = M('MemberPrice');
            foreach ($mp as $k=>$v){
                if (empty($v))
                    continue;
                $mpModel->add(array(
                    'goods_id'=>$data['id'],
                    'level_id'=>$k,
                    'price'=>$v
                ));
            }
        }

        /******************** 处理商品属性的数据 *********************/
        $ga = I('post.ga');
        $attr_price = I('post.attr_price');
        if($ga)
        {
            $gaModel = M('GoodsAttr');
            foreach ($ga as $k => $v)
            {
                foreach ($v as $k1 => $v1)
                {
                    if(empty($v1))
                        continue ;
                    $price = isset($attr_price[$k][$k1]) ? $attr_price[$k][$k1] : '';
                    $gaModel->add(array(
                        'goods_id' => $data['id'],
                        'attr_id' => $k,
                        'attr_value' => $v1,
                        'attr_price' => $price,
                    ));
                }
            }
        }
        /*************处理图片****************/
        //先判断批量上传的数组中有没有上传一张图片的
        if (hasImage('pics')){

            $gpModel = M('GoodsPics');
            //批量上传的图片改造成每次上传一张图片的形式
            $pics = array();
            foreach ($_FILES['pics']['name'] as $k =>$v){
                if ($_FILES['pics']['error'][$k]!=0){
                    continue;
                }
                $pic = array();
                $pic['name'] = $v;
                $pic['type'] = $_FILES['pics']['type'][$k];
                $pic['tmp_name'] = $_FILES['pics']['tmp_name'][$k];
                $pic['error'] = $_FILES['pics']['error'][$k];
                $pic['size'] = $_FILES['pics']['size'][$k];
                $pics[] = $pic;
            }
        }
        // 在后面调用uploadOne方法时会使用$_FILES数组上传图片，所以我们要把我们处理好的数组赎给$_FILES这样上传时使用的就是我们处理好的数组
        $_FILES = $pics;
        //循环每次上传一张图片
       foreach ($pics as $k=>$v){
           $res = uploadOne($k,'Goods',array(
              array(150,150)
           ));
           if ($res['ok']==1){
               $gpModel->add(array(
                  'goods_id'=>$data['id'],
                  'pic'=>$res['images'][0],
                  'sm_pic'=>$res['images'][1]
               ));
           }
       }

    }

    // 修改前
    protected function _before_update(&$data, $option)
    {
        /************* 判断商品类型有没有被修改， 如果修改了类型，那么就删除原来的商品属性 ***************/
        // 先取出原来的类型是什么
        if(I('post.old_type_id') != $data['type_id'])
        {
            // 删除当前商品所有之前的属性
            $gaModel = M('GoodsAttr');
            $gaModel->where(array('goods_id'=>array('eq', $option['where']['id'])))->delete();
        }
        // 如果没有勾选促销价格就手动设置为更新成0
        if(!isset($_POST['is_promote']))
            $data['is_promote'] = 0;
        else
        {
            $data['promote_start_time'] = strtotime($_POST['promote_start_time']);
            $data['promote_end_time'] = strtotime($_POST['promote_end_time']);
        }
        if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
        {
            $ret = uploadOne('logo', 'Admin', array(
                array(150, 150, 2),
            ));
            if($ret['ok'] == 1)
            {
                $data['logo'] = $ret['images'][0];
                $data['sm_logo'] = $ret['images'][1];
            }
            else
            {
                $this->error = $ret['error'];
                return FALSE;
            }
            deleteImage(array(
                I('post.old_logo'),
                I('post.old_sm_logo'),

            ));
        }
    }


	protected function _after_update($data, $options)
    {
        /*************处理扩展分类表*************/
        $extcat = I('post.ext_cat_id');
        $extcatModel = M('GoodsCat');
        //先清除商品原来的扩展分类数据
        $extcatModel->where(array('goods_id'=>$options['where']['id']))->delete();
        if ($extcat){

            foreach ($extcat as $k=>$v){
                if (empty($v))
                    continue;
                $extcatModel->add(array(
                    'goods_id'=>$options['where']['id'],
                    'cat_id'=>$v
                ));
            }
        }
        /*************处理会员价格***********/
        $mp = I('post.mp');
        $mpModel = M('MemberPrice');
        //先清除商品原来的扩展分类数据
        $mpModel->where(array('goods_id'=>$options['where']['id']))->delete();
        if ($mp){
            foreach ($mp as $k=>$v){
                if (empty($v))
                    continue;
                $mpModel->add(array(
                    'goods_id'=>$options['where']['id'],
                    'level_id'=>$k,
                    'price'=>$v
                ));
            }
        }

        /*************处理图片****************/
        //先判断批量上传的数组中有没有上传一张图片的
        if (hasImage('pics')){

            $gpModel = M('GoodsPics');
            //批量上传的图片改造成每次上传一张图片的形式
            $pics = array();
            foreach ($_FILES['pics']['name'] as $k =>$v){
                if ($_FILES['pics']['error'][$k]!=0){
                    continue;
                }
                $pic = array();
                $pic['name'] = $v;
                $pic['type'] = $_FILES['pics']['type'][$k];
                $pic['tmp_name'] = $_FILES['pics']['tmp_name'][$k];
                $pic['error'] = $_FILES['pics']['error'][$k];
                $pic['size'] = $_FILES['pics']['size'][$k];
                $pics[] = $pic;
            }
        }
        // 在后面调用uploadOne方法时会使用$_FILES数组上传图片，所以我们要把我们处理好的数组赎给$_FILES这样上传时使用的就是我们处理好的数组
        $_FILES = $pics;
        //循环每次上传一张图片
        foreach ($pics as $k=>$v){
            $res = uploadOne($k,'Goods',array(
                array(150,150)
            ));
            if ($res['ok']==1){
                $gpModel->add(array(
                    'goods_id'=>$data['id'],
                    'pic'=>$res['images'][0],
                    'sm_pic'=>$res['images'][1]
                ));
            }
        }
        /****************************** 修改商品属性的代码 ***************************/
        // 处理新属性
        $ga = I('post.ga');
        $ap = I('post.attr_price');
        $gaModel = M('GoodsAttr');
        if($ga)
        {
            foreach ($ga as $k => $v)
            {
                foreach ($v as $k1 => $v1)
                {
                    if(empty($v1))
                        continue ;
                    $price = isset($ap[$k][$k1]) ? $ap[$k][$k1] : '';
                    $gaModel->add(array(
                        'goods_id' => $options['where']['id'],
                        'attr_id' => $k,
                        'attr_value' => $v1,
                        'attr_price' => $price,
                    ));
                }
            }
        }
        // 处理原属性
        $oldga = I('post.old_ga');
        $oldap = I('post.old_attr_price');
        // 循环所更新一遍所有的旧属性
        foreach ($oldga as $k => $v)
        {
            foreach ($v as $k1 => $v1)
            {
                // 要修改的字段
                $oldField = array('attr_value' => $v1);
                // 如果有对应的价格就把价格也修改
                if(isset($oldap[$k]))
                    $oldField['attr_price'] = $oldap[$k][$k1];
                $gaModel->where(array('id'=>array('eq', $k1)))->save($oldField);
            }
        }
    }

    // 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
		$images = $this->field('logo,sm_logo')->find($option['where']['id']);
		deleteImage($images);
	}
	/************************************ 其他方法 ********************************************/
	//获取促销商品
	public function getCrazyGoods($limit = 5 ){
	    $map = array();
	    $map['is_on_sale'] = 1;
	    $map['is_delete'] = 0;
	    $map['is_promote'] = 1;
	    $map['promote_start_time'] = array('elt',time());
	    $map['promote_end_time'] = array('egt',time());
	    $crazygoods = $this->where($map)->order('sort_num ASC')->select();
	    return $crazygoods;
    }
    //获取热卖商品
    public function getHotGoods($limit = 5){
        $map = array();
        $map['is_on_sale'] = 1;
        $map['is_delete'] = 0;
        $map['is_hot'] = 1;
        $crazygoods = $this->where($map)->order('sort_num ASC')->select();
        return $crazygoods;
    }
    //获取精品推荐
    public function getBestGoods($limit = 5){
        $map = array();
        $map['is_on_sale'] = 1;
        $map['is_delete'] = 0;
        $map['is_best'] = 1;
        $crazygoods = $this->where($map)->order('sort_num ASC')->select();
        return $crazygoods;
    }
    //获取最新商品
    public function getNewGoods($limit = 5){
        $map = array();
        $map['is_on_sale'] = 1;
        $map['is_delete'] = 0;
        $map['is_new'] = 1;
        $crazygoods = $this->where($map)->order('sort_num ASC')->select();
        return $crazygoods;
    }

    public function getMemberPrice($goods_id){

        //会员商品价格逻辑
        //1.如果有促销价，会员商品的价格为促销价
        //2.如果有会员价格就用会员所在等级的价格计算。
        //3.如果没有促销价，且没有设置会员价格，则按会员的等级对应的shop_price来计算

        //有促销价直接使用促销价
        $price = $this->field('shop_price,is_promote,promote_price,promote_start_time,promote_end_time')->find($goods_id);
        if ($price['is_promote']==1&&$price['promote_start_time']<=time()&&$price['promote_end_time']>=time()){
            return $price['promote_price'];
        }
        //用户没有登录直接使用本店价
        $memberId = session('mid');
        if (!$memberId){
            return $price['shop_price'];
        }

        //用户登录了需要判断会员等级价格
        $memModel = M('MemberPrice');
        $mprice = $memModel->field('price')->where(array('level_id'=>session('level_id'),'goods_id'=>$goods_id))->find();

        if ($mprice){
            return $mprice['price'];
        }else{
            return $price['shop_price'] * session('rate');
        }

    }
    /**
     * 转化商品属性ID为商品属性字符串
     *
     */
    public function convertGoodsAttrIdToGoodsAttrStr($goods_attr_id){


        if ($goods_attr_id){
            $sql = 'SELECT GROUP_CONCAT(CONCAT( b.attr_name,  ":", a.attr_value ) separator  "<br />" ) gastr FROM shop_goods_attr a LEFT JOIN shop_attribute b ON a.attr_id = b.id WHERE a.id in ('.$goods_attr_id.')';
            $res = $this->query($sql);
            return $res[0]['gastr'];
        }
        return '';
    }
}