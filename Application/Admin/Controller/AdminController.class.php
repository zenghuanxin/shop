<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class AdminController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
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
    	$roleModel = M('Role');
    	$roleData = $roleModel->select();
    	$this->assign('roleData',$roleData);

		$this->setPageBtn('添加', '列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
        //要修改的管理员的ID
        $id = I('get.id');
        //当前管理员的id
        $adminid = session('id');
        if ($adminid!=$id&&$adminid>1){
            $this->error('无权修改!');
        }
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
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
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        $roleModel = M('Role');
        $roleData = $roleModel->select();
        $this->assign('roleData',$roleData);

    	$armodel = M('AdminRole');
    	$ardata = $armodel->field('GROUP_CONCAT(role_id) role_id')->where(array('admin_id'=>$id))->find();
    	$this->assign('role_id',$ardata['role_id']);

		$this->setPageBtn('修改', '列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Admin');
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
    	$model = D('Admin/Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('列表', '添加', U('add'));
    	$this->display();
    }
    public function setPageBtn($pagetitle,$pagebtn,$pageurl){
        $this->assign('pagetitle',$pagetitle);
        $this->assign('pagebtn',$pagebtn);
        $this->assign('pageurl',$pageurl);
    }

   public function ajaxUpdateIsuse(){
        $adminid = I('get.id');
        if($adminid == 1){
            return false;
        }
        $model = M('Admin');
        $info = $model->where(array('id'=>$adminid))->find();
        if ($info['is_use'] == 1){
            $model->where(array('id'=>$adminid))->setField('is_use',0);
            echo 0;
        }else{
            $model->where(array('id'=>$adminid))->setField('is_use',1);
            echo 1;
        }
   }

}