<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model{
    protected $insertFields = array('star','content','goods_id');

    // 表单验证规则
    protected $_validate = array(
        array('content', 'require', '评论内容不能为空！', 1, 'regex', 3),
        array('star', '/^[1-5]$/', '分值必须是1-5之间的数字！', 1),
    );

    public function _before_insert(&$data, $options)
    {
        $data['addtime'] = time();
        $data['member_id'] = session('mid');

        //处理印象数据
        $impression = I('post.impressoin');
        if ($impression){
            // 先统计字符串中的，号都用英文的
            $impression = str_replace('，',',',$impression);
            // 先把印象根据，号转化成数组
            $arrimp = explode(',',$impression);
            $model = M('Impression');
            foreach ($arrimp as $v){

                //判断商品有没有这个印象
                $has = $model->field('id')->where(array('goods_id'=>$data['goods_id'],'imp_name'=>$v))->find();
                // 这件商品已经有这个印象就把印象的数字加1
                if ($has){
                    $model->where(array('id'=>$has['id']))->setInc('imp_count');
                }else{
                    $model->add(
                        array(
                            'imp_name'=>$v,
                            'goods_id'=>$data['goods_id']
                        )
                    );
                }

            }
        }

    }

}