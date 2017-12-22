<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/15 0015
 * Time: 13:54
 */
namespace Admin\Controller;
class  TestController extends \Think\Controller{
    public function index(){
        $this->display();
    }
    public function test(){

    }
    public function test1(){
//        $color = array('red','green','blue');
//        echo json_encode($color).'<br>';
//        $animal = array('east'=>'tiger','north'=>'wolf','south'=>'monkey');
//        echo json_encode($animal).'<br>';
//        $jn_animal = json_encode($animal);
//        $animal2 = array('east'=>'tiger','north'=>'wolf','duck','south'=>'monkey');
//        echo json_encode($animal2).'<br>';
//        $anm = json_decode($jn_animal,true);
//        var_dump($anm);
//        $jn_str = "{'first':'xiaoming','second':'wangwu','three':'linken'}";
//        $jn_str = '{"first":"xiaoming","second":"wangwu","three":"linken"}';
//        var_dump(json_decode($jn_str,true));

        $weather = '{"weatherinfo":{"city":"海淀","cityid":"101010200","temp":"10","WD":"西风","WS":"2级","SD":"24%","WSE":"2","time":"10:25","isRadar":"1","Radar":"JC_RADAR_AZ9010_JB","njd":"暂无实况","qy":"1010"}}';
        echo $weather;
    }
    public function test2(){

      $model = M('Privilege');
      $pdata = $model->field('pri_name')->find(3);
      echo $this->ajaxReturn($pdata);
    }
    public function area(){
        $data = U('Public/ChinaArea.xml','',false);
        echo $data;
    }
}