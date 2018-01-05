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
    public function setEmail(){
        sendMail('413247939@qq.com','111','111');
    }
}