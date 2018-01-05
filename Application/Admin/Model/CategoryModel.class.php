<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model 
{
	protected $insertFields = array('cat_name','parent_id');
	protected $updateFields = array('id','cat_name','parent_id');
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('cat_name', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('parent_id', 'number', '上级分类的ID，0：代表顶级必须是一个整数！', 2, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
	/************************************ 其他方法 ********************************************/
	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM shop_category WHERE id IN($children)");
		}
	}

	public function getCategory(){

	    //先从缓存中取数据
        $data = S('catData');
        if ($data){
            return $data;
        }else{
            //先获取所有分类
            $catData = $this->select();
            $data =array();
            //获取顶级分类
            foreach ($catData as $k=>$v){
                if ($v['parent_id']==0){
                    //获取二级分类
                    foreach ($catData as $k1=>$v1){
                        if ($v1['parent_id'] == $v['id']){
                            //获取三级分类
                            foreach ($catData as $k2=>$v2){
                                if ($v2['parent_id']==$v1['id']){
                                    $v1['children'][$k2] = $v2;
                                }
                            }
                            $v['children'][$k1] =$v1;
                        }
                    }
                    $data[] = $v;
                }
            }
            S('catData',$data);
            return $data;
        }
    }
}