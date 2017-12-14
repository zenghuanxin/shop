<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/4 0004
 * Time: 17:35
 */
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{

    //在添加数据时调用create方法时允许接收的字段
    protected $insertFields = array('goods_name','price','goods_desc','is_on_sale');
    //在修改数据时调用create方法时允许接收的字段
    protected $updateFields  = array('goods_name','price','goods_desc','is_on_sale');//3.2.2版本的$updateFields有bug 已经在model修改

    //定义表单验证的规则，控制器中的create方法时使用
    protected $_validate = array(
        array('goods_name','require','商品名称不能为空！',1),
        array('goods_name','1,45','商品名称必须是1-45个字符！',1,'length'),
        array('price','currency','价格必须是货币格式！',1),
        array('is_on_sale','0,1','是否上架只能是0,1两个值！',1,'in')
    );

    protected function _before_insert(&$data, $options)
    {
      //获取当前时间
        $data['addtime'] = time();
        //上传logo
        if ($_FILES['logo']['error']==0){
            //tp框架手册有现成模板
            $rootPath = C('IMG_rootPath');
            $upload = new \Think\Upload(
                array('rootPath'=>$rootPath)
            );// 实例化上传类
            $upload->maxSize   =     (int)C('IMG_maxSize') * 1024 * 1024 ;// 设置附件上传大小 配置文件中图片大小是兆为单位的。所以要先转化成整形
            $upload->exts      =     C('IMG_exts');// 设置附件上传类型
            //$upload->rootPath  =    $rootPath; // 设置附件上传根目录  这是错误的TP 手册写错了
            $upload->savePath  =     'Goods/'; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            //dump($info);die();
            if(!$info) {
                // 模型中没有error方法，先把上传的失败的错误信息存在模型中，然后在控制器中把信息输出
               $this->error = $upload->getError();
                return false;
            }else{// 上传成功
                //tp框架中有现成的缩略图模板

                $logoname = $info['logo']['savepath'].$info['logo']['savename'];//logo保存的文件名
                $sm_logoname = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];//缩略图的文件名

                $image = new \Think\Image();
                $image->open($rootPath.$logoname);//打开logo文件
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                $result = $image->thumb(150, 150)->save($rootPath.$sm_logoname);//保存缩略图

                $data['logo'] = $logoname;//将logo地址存入数据库。
                $data['sm_logo'] = $sm_logoname;
            }
        }

    }
    //在控制器中调用delete方法之前会自动调用
    public function _before_delete($options)
    {
       //现根据商品的ID取出这件商品的图片的路径
        $logo = $this->field('logo,sm_logo')->find($options['where']['id']);
        //从配置文件取出商品所在目录
        $rp = C('IMG_rootPath');
        //删除图片
        unlink($rp.$logo['logo']);
        unlink($rp.$logo['sm_logo']);
    }

    public function _before_update(&$data,$options)
    {
        //上传logo
        if ($_FILES['logo']['error']==0) {
            //tp框架手册有现成模板
            $rootPath = C('IMG_rootPath');
            $upload = new \Think\Upload(
                array('rootPath' => $rootPath)
            );// 实例化上传类
            $upload->maxSize = (int)C('IMG_maxSize') * 1024 * 1024;// 设置附件上传大小 配置文件中图片大小是兆为单位的。所以要先转化成整形
            $upload->exts = C('IMG_exts');// 设置附件上传类型
            //$upload->rootPath  =    $rootPath; // 设置附件上传根目录  这是错误的TP 手册写错了
            $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
            // 上传文件
            $info = $upload->upload();
            //dump($info);die();
            if (!$info) {
                // 模型中没有error方法，先把上传的失败的错误信息存在模型中，然后在控制器中把信息输出
                $this->error = $upload->getError();
                return false;
            } else {// 上传成功
                //tp框架中有现成的缩略图模板

                $logoname = $info['logo']['savepath'] . $info['logo']['savename'];//logo保存的文件名
                $sm_logoname = $info['logo']['savepath'] . 'sm_' . $info['logo']['savename'];//缩略图的文件名

                $image = new \Think\Image();
                $image->open($rootPath . $logoname);//打开logo文件
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                $result = $image->thumb(150, 150)->save($rootPath . $sm_logoname);//保存缩略图

                $data['logo'] = $logoname;//将logo地址存入数据库。
                $data['sm_logo'] = $sm_logoname;

                $logoinfo = $this->field('logo,sm_logo')->find($options['where']['id']);
                $rp = $rootPath;
                unlink($rp.$logoname);
                unlink($rp.$sm_logoname);
            }
        }

    }

    public function search(){
        /***********搜索*************/
        $where =array();//默认情况下的搜索条件为空

        //商品名称
        $goodsName = I('get.goods_name');
        if ($goodsName){
            $where['goods_name'] = array('like','%'.$goodsName.'%');
        }
        //商品价格搜索
        $startPrice = I('get.start_price');
        $endPrice = I('get.end_price');

        if ($startPrice && $endPrice){
            $where['price'] = array('between',array($startPrice,$endPrice));
        }elseif($startPrice){
            $where['price'] = array('egt',$startPrice);
        }elseif($endPrice){
            $where['price'] = array('elt',$endPrice);
        }
        //时间搜索
        $start_addtime = I('get.start_addtime');
        $end_addtime = I('get.end_addtime');
        if ($start_addtime&&$end_addtime){
            $where['addtime'] = array('between',array(strtotime("$start_addtime 00:00:01"),strtotime("$end_addtime 23:59:59")));
        }elseif($start_addtime){
            $where['addtime'] = array('egt',strtotime("$start_addtime 00:00:01"));
        }else if($end_addtime){
            $where['addtime'] = array('elt',strtotime("$end_addtime 23:59:59"));
        }

        //上架搜索
        $isOnSale = I('get.is_on_sale',-1);
        if ($isOnSale!=-1){
            $where['is_on_sale'] = array('eq',$isOnSale);
        }
        //是否删除的搜索
        $isDelete = I('get.is_delete',-1);
        if ($isDelete!=-1){
            $where['is_delete'] = array('eq',$isDelete);
        }

        /***************排序********************/
        $orderby = 'id'; //默认排序字段
        $orderway = 'asc'; //默认排序方式
        $odby = I('get.odby');
        if ($odby&& in_array($odby,array('id_asc','id_desc','price_asc','price_desc'))){
            if ($odby == 'id_desc'){
                $orderway = 'desc';
            }elseif($odby == 'price_asc'){
                $orderby = 'price';
            }elseif ($odby == 'price_desc'){
                $orderby = 'price';
                $orderway = 'desc';
            }
        }


        /***************翻页**************/
        //总的记录数
        $count = $this->where($where)->count();
        //生成翻页对象
        $page = new \Think\Page($count,2);

        $page->setConfig('next','下一页');
        $page->setConfig('prev','上一页');
        //获取翻页字符串
        $pageString = $page->show();
        //取出当前页的数据
        $data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->order("$orderby $orderway")->select();

        return array(
          'page'=>$pageString,
          'data'=>$data,
        );
    }
}