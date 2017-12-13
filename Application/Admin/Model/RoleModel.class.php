<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '', '角色名称已经存在！', 1, 'unique', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		//$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		$data['data'] = $this->field('a.*,GROUP_CONCAT(pri_name) pri_name')->alias('a')->join('LEFT JOIN shop_role_privilege b on b.role_id=a.id LEFT JOIN shop_privilege c on c.id=b.pri_id')->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
        return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	//添加后
    protected function _after_insert($data, $option)
    {
        $priId = I('post.pri_id');
       if ($priId){
           $rpModel = M('RolePrivilege');
           foreach ($priId as $k =>$v){
               $rpModel->add(array('pri_id'=>$v,'role_id'=>$data['id']));
           }
       }
    }

    // 修改前
	protected function _before_update(&$data, $option)
	{
	    //先删除原来的权限
	    $rpModel = M('RolePrivilege');
	    $rpModel->where('role_id',array('eq',$option['where']['id']))->delete();
	    //接受表单重新添加一遍
        $priId = I('post.pri_id');
        if ($priId){
            foreach ($priId as $v){
                $rpModel->add(array('role_id'=>$option['where']['id'],'pri_id'=>$v));
            }
        }
	}
	// 删除前
	protected function _before_delete($option)
	{
        //先判断有没有管理员属于这个角色-要读管理员角色表
        $arModel = M('AdminRole');
        $has = $arModel->where(array('role_id'=>array('eq',$option['where']['id'])))->count();
        if ($has>0){
            $this->error = '有管理员属于这个角色，无法删除！';
            return false;
        }

        //把这个角色所有的权限的数据一起删除
        $rpModel = M('RolePrivilege');
        $rpModel->where(array('role_id'=>array('eq',$option['where']['id'])))->delete();

	    if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}