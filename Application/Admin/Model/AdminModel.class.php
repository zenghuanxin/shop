<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','cpassword','is_use','checkcode');
	protected $updateFields = array('id','username','password','cpassword','is_use');

    //登录时使用的验证表单的规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('password', 'require', '密码不能为空！', 1),
        array('checkcode', 'require', '验证码不能为空！', 1),
        array('checkcode', 'chk_checkcode', '验证码不正确！', 1, 'callback')
    );

	protected $_validate = array(
		array('username', 'require', '账号不能为空！', 1, 'regex', 3),
		array('username', '1,30', '账号的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('username', '', '账号已经存在！', 1, 'unique', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('cpassword', 'password', '两次密码输入不正确！', 1, 'confirm', 3),
		array('is_use', 'number', '是否启用  1：启用 0：禁用必须是一个整数！', 2, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		$is_use = I('get.is_use');
		if($is_use != '' && $is_use != '-1')
			$where['is_use'] = array('eq', $is_use);
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	    $data['password'] = md5(C('MD5_KEY').$data['password']);
	}
	protected function _after_insert($data, $options)
    {
        $role_id = I('post.role_id');

        if ($role_id){
            $arModel = M('AdminRole');
            foreach ($role_id as $v){
                $arModel->add(array('role_id'=>$v,'admin_id'=>$data['id']));
            }
        }
    }

    // 修改前
	protected function _before_update(&$data, $option)
	{

	    //超级管理员无法被禁用
        if ($option['where']['id'] == 1){
          $data['is_use'] = 1;
        }
	    $password = I('post.password');
	    if (empty($password)){
	       // $data['password'] = $adminModel->field('password')->where(array('id'=>$option['where']['id']))->find();
            unset($data['password']);
	    }else{
	        $data['password'] = md5($password.C('MD5_KEY'));
        }

        $role_id = I('post.role_id');
	    //先删除原来的数据
        $armodel = M('AdminRole');
        $armodel->where(array('admin_id'=>$option['where']['id']))->delete();
        if ($role_id){
            $arModel = M('AdminRole');
            foreach ($role_id as $v){
                $arModel->add(array('role_id'=>$v,'admin_id'=>$option['where']['id']));
            }
        }


	}
	// 删除前
	protected function _before_delete($option)
	{
	    if ($option['where']['id']==1){
	        $this->error = '超级管理员不能被删除!';
	        return false;
        }
        //在删除admin表中管理员的数据时候先删除中间表admin_role 中管理员对应的权限数据
	    $raModel = M('AdminRole');
	    $raModel->where(array('admin_id'=>$option['where']['id']))->delete();
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/

    public function chk_checkcode($code)
    {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    public function login()
    {

        //获取表单中用户名和密码
        $username = $this->username;
        $password = $this->password;
        //先查询数据库有没有这个账号
        $user = $this->where(array('username' => array('eq', $username)))->find();
        //判断有没有账号
        if ($user) {
            //判断是否启用（超级管理员不能禁用）
            if ($user['id'] == 1 || $user['is_use'] == 1) {
                if ($user['password'] == md5($password . C('MD5_KEY'))) {
                    //把ID和用户名存到session中
                    session('id', $user['id']);
                    session('username', $user['username']);
                    return true;
                } else {
                    $this->error = '密码不正确!';
                    return false;
                }
            } else {
                $this->error = '账号被禁用';
                return false;
            }
        } else {
            $this->error = '没有该用户';
            return false;
        }
    }
}