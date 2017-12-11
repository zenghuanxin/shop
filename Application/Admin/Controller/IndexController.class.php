<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        //验证登录
        if (!session('id')){
            redirect(U('Admin/Login/login'));
        }
        //先调用父类的构造函数
        parent::__construct();//语法要求  没有实际意义
    }
    public function index(){

        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
}