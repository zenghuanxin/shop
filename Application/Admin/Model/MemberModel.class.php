<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model{
    protected $insertFields = array('email','password','cpassword','checkcode','mustsbm');
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
        dump($data);die();
    }

    protected function _after_insert($data, $options)
    {
        //发送邮件进行验证
        $content = <<<HTML
        <p>'恭喜您注册成功！请到改网站进行验证登录'</p>
       <p><a href="http://www.34.com/index.php/Home/Member/emailchk/code/{$data['email_code']}">点击完成验证</a></p>
HTML;

        // 把生成的验证码发到会员的邮箱中
        sendMail($data['email'], '邮箱地址验证测试', $content);
    }
}