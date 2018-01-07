<?php
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model{
    protected $insertFields = array('email','password','cpassword','checkcode','mustsbm');

    public $_login_validate = array(
        array('email', 'require', '邮箱不能为空！', 1, 'regex', 3),
        array('email', 'email', '邮箱格式不正确！', 1, 'regex', 3),
        array('password', 'require', '密码不能为空！', 1, 'regex', 3),
        array('password', '6-20', '密码长度必须为6-20位！', 1, 'length', 3),
        array('checkcode', 'require', '验证码不能为空！', 1, 'regex', 3),
        array('checkcode', 'chk_chkcode', '验证码不正确！', 1, 'callback', 3),
    );

    // 注册时的表单验证规则
    protected $_validate = array(
        array('mustsbm', 'require', '必须同意注册协议才能注册！', 1),
        array('email', 'require', '邮箱不能为空！', 1, 'regex', 3),
        array('email', 'email', '邮箱格式不正确！', 1, 'regex', 3),
        array('password', 'require', '密码不能为空！', 1, 'regex', 3),
        array('password', '6-20', '密码长度必须为6-20位！', 1, 'length', 3),
        array('password', 'cpassword', '两次输入的密码不一致！', 1, 'confirm', 3),
        array('checkcode', 'require', '验证码不能为空！', 1, 'regex', 3),
        array('checkcode', 'chk_chkcode', '验证码不正确！', 1, 'callback', 3),
        array('email', '', 'email已经被注册过了！', 1, 'unique'),

    );
    public function chk_chkcode($code)
    {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    // 在会员记录插入到数据库之前
    protected function _before_insert(&$data, $option)
    {
        $data['addtime'] = time();  // 注册的当前时间
        // 生成验证email用的验证码
        $data['email_code'] = md5(uniqid());
        // 先把会员的密码加密
        $data['password'] = md5($data['password'] . C('MD5_KEY'));
    }
    // 在会员注册成功之后
    protected function _after_insert($data, $option)
    {
        // heredoc的语法
        $content =<<<HTML
		<p>欢迎您成为本站会员，请点击以下链接地址完成email验证。</p>
		<p><a href="http://www.shop.com/index.php/Home/Member/emailchk/code/{$data['email_code']}">点击完成验证</a></p>
HTML;
        // 把生成的验证码发到会员的邮箱中
        sendMail($data['email'], '邮箱注册', $content);
    }
    //用户登录
    public function login(){

        $username = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->where(array('email'=>$username))->find();
        if ($user){
            if (empty($user['email_code'])){
                if ($user['password'] == md5($password.C('MD5_KEY'))){
                    session('id',$user['id']);
                    session('email',$user['email']);
                    return true;
                }
            }else{
                $this->error = '该用户还未认证,请认证后再尝试登录！';
                return false;
            }
        }else{
            $this->error = '不存在该用户,请注册后再尝试登录！';
            return false;
        }
    }
}