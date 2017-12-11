<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="JavaScript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" language="JavaScript" src="/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" charset="utf-8" language="JavaScript" src="/Public/datepicker/datepicker_zh-cn.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .current{padding: 5px;margin: 3px;background: #F00;color:#FFF;font-weight: bold; }
        .num{padding: 5px;border: 1px solid #F00;margin: 3px;}
    </style>
    <title>Title</title>
</head>
<body>
<form action="" method="" class="goods_form">
    <input type="hidden" name="p" value="1">
    商品名称:<input type="text" name="goods_name" value="<?php echo I('get.goods_name');?>"><br>
    价    格:<input type="text" name="start_price" value="<?php echo I('get.start_price');?>">--<input type="text" name="end_price" value="<?php echo I('get.end_price');?>"><br>
    添加时间:<input type="text" size="8" id="start_addtime" name="start_addtime" value="<?php echo I('get.start_addtime');?>">--
             <input type="text" size="8" id="end_addtime" name="end_addtime" value="<?php echo I('get.end_addtime');?>"><br>
    是否上架:<input type="radio" name="is_on_sale" value="-1" <?php if (I('get.is_on_sale',-1) == -1) echo 'checked="checked"';?> />全部
             <input type="radio" name="is_on_sale" value="1" <?php if (I('get.is_on_sale',-1) == 1) echo 'checked="checked"';?> />是
             <input type="radio" name="is_on_sale" value="0" <?php if (I('get.is_on_sale',-1) == 0) echo 'checked="checked"';?> />否<br>

    是否删除:<input type="radio" name="is_detele" value="-1" <?php if (I('get.is_detele',-1) == -1) echo 'checked="checked"';?> />全部
             <input type="radio" name="is_detele" value="1" <?php if (I('get.is_detele',-1) == 1) echo 'checked="checked"';?> />是
             <input type="radio" name="is_detele" value="0" <?php if (I('get.is_detele',-1) == 0) echo 'checked="checked"';?> />否<br>

    排序方式:<input type="radio" name="odby" value="id_asc" <?php if (I('get.odby','id_asc') == 'id_asc') echo 'checked="checked"';?> />根据添加id升序排序
             <input type="radio" name="odby" value="id_desc" <?php if (I('get.odby','id_asc') == 'id_desc') echo 'checked="checked"';?> />根据添加id降序排序
             <input type="radio" name="odby" value="price_asc" <?php if (I('get.odby','id_asc') == 'price_asc') echo 'checked="checked"';?>/>根据添加价格升序排序
             <input type="radio" name="odby" value="price_desc" <?php if (I('get.odby','id_asc') == 'price_desc') echo 'checked="checked"';?> />根据添加降序升序排序<br>

    <input type="submit" value="提交"><br>
</form>
<table border="1px" cellpadding="5" cellspacing="5" width="100%">
    <tr>
        <th>id</th>
        <th>商品名称</th>
        <th>LOGO</th>
        <th>价格</th>
        <th>描述</th>
        <th>添加时间</th>
        <th>是否上架</th>
        <th>是否删除</th>
        <th>操作</th>
    </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["goods_name"]); ?></td>
            <td><img src="/Public/Uploads/<?php echo ($vo["sm_logo"]); ?>" /></td>
            <td><?php echo ($vo["price"]); ?></td>
            <td><?php echo ($vo["goods_desc"]); ?></td>
            <td><?php echo (date("y-m-d h:i:s",$vo["addtime"])); ?></td>
            <td><?php if($vo["is_on_sale"] == 1): ?>上架
                <?php else: ?> 下架<?php endif; ?>
            </td>
            <td><?php if($vo["is_delete"] == 0): ?>未删除
                <?php else: ?> 已删除<?php endif; ?>
            </td>
            <td><a href="<?php echo U('edit',array('id'=>$vo['id'],'p'=>I('get.p',1)));?>">修改</a> <a  onclick="return confirm('确定要删除吗？');" href="<?php echo U('delete',array('id'=>$vo['id'],'p'=>I('get.p',1)));?>">删除</a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr><td colspan="9">
        <div>
            <span class="current">1</span>
            <a class="num" href="/index.php/Admin/Goods/lst/p/2.html">2</a>
            <a class="num" href="/index.php/Admin/Goods/lst/p/3.html">3</a>
            <a class="next" href="/index.php/Admin/Goods/lst/p/2.html">下一页</a>
        </div>
        </td>
    </tr>
</table>
</body>
</html>
<script>

    $("#start_addtime").datepicker({dateFormat:'yy-mm-dd'});
    $("#end_addtime").datepicker({dateFormat:'yy-mm-dd'});

    $(".goods_form").submit(function () {
        return false;
    });
</script>