<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function __construct()
    {
        //先调用父类的构造函数
        parent::__construct();//语法要求  没有实际意义
        //验证登录
        $adminid= session('id');
        if (!$adminid){
            redirect(U('Admin/Login/login'));
        }
        //验证当前管理员是否有权限访问这个页面
        //获取当前管理员所要访问的页面的url地址  TP三个常量
        $url = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        //查询数据库判断当前管理员有没有访问这个页面的权限
        $where = 'module_name="'.MODULE_NAME.'" AND controller_name="'.CONTROLLER_NAME.'" AND action_name="'.ACTION_NAME.'"';
        //任何人只要登录了就可以进入后台
        if (CONTROLLER_NAME == "Index"){
            return true;
        }

        if ($adminid == 1){
            $sql = 'select count(*) has from shop_privilege';
        }else{
            $sql = 'select count(*) has
            from shop_role_privilege a
            LEFT JOIN shop_privilege b on a.pri_id = b.id
            LEFT JOIN shop_admin_role c on a.role_id = c.role_id
            WHERE c.admin_id ='.$adminid.' AND '.$where;
        }

        $db = M();
        $pri = $db->query($sql);
        if ($pri[0]['has'] < 1){
            $this->error('无权访问！');
        }

    }
    public function index(){

        $this->display();
    }
    public function menu(){

        $adminid = session('id');
        if ($adminid == 1){
            $sql = 'select * from shop_privilege';
        }else{
            $sql = 'select b.*
            from shop_role_privilege a
            LEFT JOIN shop_privilege b on a.pri_id = b.id
            LEFT JOIN shop_admin_role c on a.role_id = c.role_id
            WHERE c.admin_id ='.$adminid;
        }
        $db = M();
        $pri = $db->query($sql);


        $btn = array();
        foreach ($pri as $v){

           if($v['parent_id']==0){

               foreach ($pri as $v1){
                   if ($v1['parent_id'] ==$v['id'] ){
                        $v['children'][] = $v1;
                   }

               }
               $btn[] = $v;
           }
        }
        $this->assign('btn',$btn);
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
}