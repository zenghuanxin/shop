<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/4 0004
 * Time: 17:35
 */
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model
{

    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('password', 'require', '密码不能为空！', 1),
        array('checkcode', 'require', '验证码不能为空！', 1),
        array('checkcode', 'chk_checkcode', '用户名不能为空！', 1, 'callback'),
    );

    public function chk_checkcode($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
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
                if ($user['password'] == $password) {
                    //把ID和用户名存到session中
                    session('id', $user['id']);
                    session('username', $user['username']);
                    return true;
                } else {
                    $this->error = '密码不正确!';
                    return false;
                }
            }else{
                $this->error = '账号被禁用';
                return false;
            }
        }else{
            $this->error = '没有该用户';
            return false;
        }
    }
}