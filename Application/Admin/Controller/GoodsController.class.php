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
        $gcData = $gcModel->field('goods_id,cat_id')->where(array('goods_id'=>$id))->select();
        $this->assign('gcData',$gcData);

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
        foreach ($gaData as $k=>$v){
            $attr_id[] = $v['attr_id'];
        }
        $attr_id = array_unique($attr_id);
        $attrModel = M('Attribute');
        $otherattr = $attrModel->field('id,attr_name,attr_type,attr_option_values')->where(array('type_id'=>$data['type_id'], 'id'=>array('not in', $attr_id)))->select();

        if ($otherattr){

            // 把新的属性和原属性合并起来
            $gaData = array_merge($gaData, $otherattr);
            // 重新根据attr_id字段重新排序这个合并之后二维数组
            usort($gaData, 'attr_id_sort');
        }
        $this->assign('gaData',$gaData);


		$this->setPageBtn('修改商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Goods');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
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
    public function setPageBtn($pagetitle,$pagebtn,$pageurl){
        $this->assign('pagetitle',$pagetitle);
        $this->assign('pagebtn',$pagebtn);
        $this->assign('pageurl',$pageurl);
    }

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
}