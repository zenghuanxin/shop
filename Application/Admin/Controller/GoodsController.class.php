<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class GoodsController extends IndexController 
{

    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Goods');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

    	$typeModel = M('Type');
    	$typeData = $typeModel->select();
    	$this->assign('typeData',$typeData);

    	//取出所有的商品分类
        $catModel = D('Category');
        $catData = $catModel->getTree();
        $this->assign('catData',$catData);

        //取出所有品牌
        $brandModel = M('Brand');
        $brandData = $brandModel->select();
        $this->assign('brandData',$brandData);

        //取出会员级别数据
        $memlevelModel = M('MemberLevel');
        $memData = $memlevelModel->select();
        $this->assign('memData',$memData);

		$this->setPageBtn('添加商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }

    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Admin/Goods');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Goods');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        //取出所有的商品主分类
        $catModel = D('Category');
        $catData = $catModel->getTree();
        $this->assign('catData',$catData);

        //取出所有的商品分类
        $gcModel = D('GoodsCat');
        $extCatId = $gcModel->field('goods_id,cat_id')->where(array('goods_id'=>$id))->select();
        $this->assign('extCatId',$extCatId);

        //取出所有品牌
        $brandModel = M('Brand');
        $brandData = $brandModel->select();
        $this->assign('brandData',$brandData);

        //取出会员级别数据
        $mlModel = M('MemberLevel');
        $mlData = $mlModel->select();
        $this->assign('mlData',$mlData);

        //取出会员价格数据
        $mpModel = M('MemberPrice');
        $mpData = $mpModel->where(array('goods_id'=>$id))->getField('level_id,price');
        $this->assign('mpData',$mpData);

        // 取出所有的商品类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData', $typeData);

        //取出商品属性对应的所有值
        $gaModel = M('GoodsAttr');
        $gaData = $gaModel->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')->alias('a')->join('LEFT JOIN shop_attribute b ON a.attr_id=b.id')->where(array('a.goods_id'=>array('eq', $id)))->order('a.attr_id ASC')->select();
        /**************************** 取出当前商品属性不存在的后添加的新的属性 **************************/
        // 循环属性数组取出当前商品已经拥有的属性ID
        $attr_id = array();
        foreach ($gaData as $k => $v)
        {
            $attr_id[] = $v['attr_id'];
        }
        $attr_id = array_unique($attr_id);
        // 取出当前类型下的后添加的新属性
        $attrModel = M('Attribute');
        $otherAttr = $allAttrId = $attrModel->field('id attr_id,attr_name,attr_type,attr_option_values')->where(array('type_id'=>array('eq', $data['type_id']), 'id'=>array('not in', $attr_id)))->select();
        if($otherAttr)
        {
            // 把新的属性和原属性合并起来
            $gaData = array_merge($gaData, $otherAttr);
            // 重新根据attr_id字段重新排序这个合并之后二维数组
            usort($gaData, 'attr_id_sort');
        }
        $this->assign('gaData', $gaData);
        // 取出当前商品的图片
        $gpModel = M('GoodsPics');
        $gpData = $gpModel->where(array('goods_id'=>array('eq', $id)))->select();
        $this->assign('gpData', $gpData);
		$this->setPageBtn('修改商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Goods');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('recycleLst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin/Goods');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('商品列表', '添加商品', U('add'));
    	$this->display();
    }
    //将商品加入回收站
    public function recycle(){
        $id = I('get.id');
        $model = M('Goods');
        $model->where(array('id'=>$id))->setField('is_delete',1);
        $this->success('操作成功！', U('lst', array('p' => I('get.p', 1))));
    }
    //将还原回收站中的商品
    public function restore(){
        $id = I('get.id');
        $model = M('Goods');
        $model->where(array('id'=>$id))->setField('is_delete',0);
        $this->success('操作成功！', U('recycleLst', array('p' => I('get.p', 1))));
    }
    //回收站中的商品
    public function recycleLst(){
        $model = D('Admin/Goods');
        $data = $model->search(20,1);
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));
        $this->setPageBtn('回收站商品列表', '商品列表', U('lst'));
        $this->display();

    }

    //获得商品属性
    public function ajaxGetAttr(){
        $type_id = I('get.type_id');
        $attrModel = M('Attribute');
        $attrdata = $attrModel->where(array('type_id'=>$type_id))->select();
        if ($attrdata){
            echo json_encode($attrdata);
        }else{
            echo '数据请求失败';
        }
    }
    //删除商品图片
    public function ajaxDelImage(){
        $pic_id = I('get.pic_id');
        $picModel = M('GoodsPics');
        $images = $picModel->field('pic,sm_pic')->find($pic_id);
        deleteImage($images);
        $res = $picModel->where(array('id'=>$pic_id))->delete();
        echo $res;
    }
    //删除商品属性
    public function ajaxDelGoodsAttr(){
        $gaid =I('get.gaid');
        $gaModel = M('GoodsAttr');
        $gaData = $gaModel->where(array('id'=>$gaid))->delete();
        echo $gaData;
    }

    public function goodsNum(){
        //先接收商品ID
        $goodsId = I('get.id');
        if (IS_POST){
            //添加的时候先把原来的数据删除
            $gnModel = M('GoodsNumber');
            $gnModel->where(array('goods_id'=>$goodsId))->delete();
            $gaid = I('post.goods_attr_id');
            $gn = I('post.goods_num');
            //一个库存量对应几条属性ID
            $rate = count($gaid)/count($gn);
            $_i = 0; //记录取出的第几个属性id
            foreach ($gn as $v){
                $_arr = array();//存放不同库存两对应的属性ID
                for ($i=0;$i<$rate;$i++){
                    $_arr[] = $gaid[$_i];
                    $_i++;
                }
                //对属性id的数组进行升序排列
                sort($_arr);
                $_arr = implode(',',$_arr);//将数组转化成字符串
                $res = $gnModel->add(array(
                    'goods_id'=>$goodsId,
                    'goods_number'=>$v,
                    'goods_attr_id'=>$_arr
                ));
            }
            $this->success('操作成功！', U('lst', array('p' => I('get.p', 1))));

        }

        $sql = 'select a.*,b.attr_name from shop_goods_attr a 
                LEFT JOIN shop_attribute b ON a.attr_id=b.id
                where a.attr_id in
                (select attr_id from shop_goods_attr WHERE goods_id='.$goodsId.' GROUP BY attr_id HAVING count(*)>1) and a.goods_id='.$goodsId;
        $model = M();
        $_attr = $model->query($sql);
        //处理这个数组，把属性相同的放到一起
        $attr =array();
        foreach ($_attr as $k=>$v){
            $attr[$v['attr_id']][] = $v;
        }
        $this->assign('attr',$attr);

        //先取出当前商品已经设置过的库存量以便修改
        $gnModel = M('GoodsNumber');
        $gnData = $gnModel->where(array('goods_id'=>$goodsId))->select();
        $this->assign('gnData',$gnData);


        $this->setPageBtn('库存设置', '商品列表', U('lst?p='.I('get.p')));
        $this->display();
    }


    public function setPageBtn($pagetitle,$pagebtn,$pageurl){
        $this->assign('pagetitle',$pagetitle);
        $this->assign('pagebtn',$pagebtn);
        $this->assign('pageurl',$pageurl);
    }
}