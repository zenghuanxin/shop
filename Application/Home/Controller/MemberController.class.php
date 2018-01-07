<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class MemberController extends BaseController {
    public function regist(){

        if(IS_POST)
        {
            $model = D('Admin/Member');
            if($model->create(I('post.'), 1))
            {
                if($model->add())
                {
                    $this->success('注册成功，请登录到您的邮件中完成验证！');
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->setPageInfo('会员注册','会员注册','会员注册','1',array('login'));
        $this->display();
    }

    //对注册账号进行验证
    public function emailchk(){
        $email_code = I('get.code');
        $model = M('Member');
        $user = $model->where(array('email_code'=>$email_code))->find();
        if ($user){
            $model ->where(array('id'=>$user['id']))->setField('email_code','');
            $this->success('验证成功，您可以到登录页面进行登录，进行购物！',U('login'));
        }else{
            $this->error('验证失败，请重新验证');
        }
    }

    //用户登录
    public function login(){
        if(IS_POST)
        {
            $model = D('Admin/Member');
            if($model->validate($model->_login_validate)->create(I('post.'), 9))//1,2,3都有实际的代表意义
            {
                if($model->login())
                {
                    redirect('/');
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->setPageInfo('会员登录','会员登录','会员登录','1',array('login'));
        $this->display();
    }
    //退出登录
    public function logout(){
        session(null);
        redirect('/');
    }

    public function chkcode(){
        $Verify = new \Think\Verify(
            array(
                'fontSize'    =>    30,    // 验证码字体大小
                'length'      =>    4,     // 验证码位数
                'useNoise'    =>    false, // 关闭验证码杂点
            )
        );
        $Verify->entry();
    }
    //ajax局部更新登录状态
    public function ajaxGetLogin(){
        if(session('id')){
            $arr = array(
                'ok'=>1,
                'email'=>session('email'),
            );
        }else{
            $arr = array(
                'ok'=>0
            );
        }
        echo  json_encode($arr);
    }


}