<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends IndexController {

    public function add(){
        //2.处理表单
        if (IS_POST){
            //3.先生成模型
            //D和M的区别：D生成我们自己创建的模型对象，M生成TP自带的模型对象
            //这里我们要生成我们自己创建的模型，因为这里要使用我们自己创建的模型中的验证规则来验证表单
            //这里用M可以添加成功但是验证表单的功能会失败，因为验证规则是在我们自己定义的模型中的，而
            //M生成的没有验证规则
            $model = D('Goods');
            //4.a接收表单中所有数据并保存到模型中， b.使用I函数过滤数据，c.根据模型中定义规则验证表单
            if ($model->create(I('post.'),1)){//如果要让$insertFields 和$updateFields生效的话，要先让create知道你是要添加还是修改
                /*
                 * 那么TP在调用create方法时是如何判断当前是一个什么表单的？
                    答：方法一、如果表单中有一个表的主键字段(id)就认为是修改。
                    方法二、在create方法时传第二个参数标记当前是一个什么类型的表单：其中1：添加 2：修改
                 * */
                //5.插入数据库
                if ($model->add()){
                    //6.提示信息
                    $this->success('操作成功！',U('lst'));
                    //7.停止执行后面代码
                    exit();
                }

            }
            //8.如果上面失败，获取失败的原因
            $error = $model->getError();
            //9.显示错误信息，并跳转回上一个页面
            $this->error($error);
        }
        //1.显示表单
        $this->display();
    }

    public function lst(){

        $model = D('Goods');
        //获取带翻页的数据
        $data = $model->search();
        $this->assign(
            array('data'=>$data['data'],'page'=>$data['page'])
        );

        $this->display();

    }

    public function delete(){

        $model = D('Goods');
        $model->delete(I('get.id'));
        $this->success('操作成功！',U('lst?p='.I('get.p')));
    }

    public function edit(){

        if (IS_POST){

            $model = D('Goods');
            if ($model->create(I('post.'),2)){

                //save方法的返回值是影响的记录数（mysql_affected_rows）,如果修改时没有修改任何值会返回0，如果修改失败返回false
                if (false!==$model->save()){
                    $this->success('操作成功!',U('lst?p='.I('get.p')));
                    exit();
                }
            }
            //如果失败显示错误信息
            $this->error($model->getError());
        }

        //接收商品的ID
        $id = I('get.id');
        //先从数据库中取出要修改的记录信息
        $model = M('Goods');
        $info = $model->find($id);
        $this->assign('info',$info);
        //显示修改的表单
        $this->display();
    }
    public function test(){
        //mysql的锁。高并发可能造成堵塞
//        mysql_connect('127.0.0.1','root','root');
//        mysql_select_db('test');
//        mysql_query('lock table a write');
//        $rs = mysql_query('select * from a');
//        $row = mysql_fetch_row($rs);
//        $id = $row[0];
//        $id--;
//        mysql_query('update a set id ='.$id);
//
//        mysql_query('unlock tables');

        mysql_connect('127.0.0.1','root','root');
        mysql_select_db('test');

        //打开锁文件
        $fp = fopen('a.lock','w');
        //开锁
        flock($fp,LOCK_EX);

        $rs = mysql_query('select id from a');
        $row = mysql_fetch_row($rs);
        $id = $row[0];
        dump($id);
        $id--;
        mysql_query('update a set id ='.$id);

        //释放锁
        flock($fp,LOCK_UN);
        fclose($fp);
    }



}