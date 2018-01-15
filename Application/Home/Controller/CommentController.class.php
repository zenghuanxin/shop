<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommentController extends BaseController {
    public function add(){

        // 判断有没有登录
        $mid = session('mid');
        if(!$mid)
        {
            echo json_encode(array(
                'ok' => 0,
                'error' => '必须先登录',
            ));
            exit;
        }

        if (IS_POST){
            // 根据表单并根据模型中定义的规则验证表单
            $model = D('Admin/Comment');
            if($model->create(I('post.'), 1))
            {
                if($model->add())
                {
                    // 取出会员的头像
                    $memberModel = M('Member');
                    $face = $memberModel->field('face')->find($mid);
                    // 如果没有设置头像就返回默认头像
                    $realFace = !$face['face'] ? '/Public/Home/images/default_face.jpg' : '/Public/Home/'.$face['face'];
                    echo json_encode(array(
                        'ok' => 1,
                        'content' => I('post.content'), // 过滤之后的内容
                        'addtime' => date('Y-m-d H:i'),
                        'star' => I('post.star'),
                        'email' => session('email'),
                        'face' => $realFace,
                    ));
                    exit;
                }
            }
            echo json_encode(array(
                'ok' => 0,
                'error' => $model->getError(),
            ));
        }
    }

    public function getComment(){
        $goods_id = I('get.goods_id');
        $page = I('get.p');
        $pagesize = 5;
        $model = M('Comment');
        //偏移量
        $offset = ($page-1)*$pagesize;
        $data = $model->field('a.*,b.email,b.icon,COUNT(c.id) reply_count')->alias('a')->join('left join shop_member b on a.member_id = b.id left join shop_reply c on c.comment_id = a.id')->where(array('a.goods_id'=>$goods_id))->limit("$offset,$pagesize")->group('a.id')->order('a.id DESC')->select();

        //处理数据
        foreach ($data as $k=>$v){

            $data[$k]['icon'] = $v['icon'] ? '/Public/Home/'.$v['icon'] : '/Public/Home/images/default_face.jpg';
            $data[$k]['addtime'] = date('Y-m-d H:i', $v['addtime']);
        }
        echo json_encode($data);
    }

}