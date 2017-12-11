<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller 
{
    public function login(){
        //显示表单
        if (IS_POST){

            $model = D('Admin');

            if ($model->validate($model->_login_validate)->create()){

                if (true === $model->login()){
                    redirect(U('Admin/Index/index'));//直接跳转。不提示信息
                }
            }
            $this->error($model->getError());
        }

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
}














