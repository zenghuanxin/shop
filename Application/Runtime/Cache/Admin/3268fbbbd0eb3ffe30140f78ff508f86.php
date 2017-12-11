<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>商品列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
    <link href="/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="JavaScript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" language="JavaScript" src="/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" charset="utf-8" language="JavaScript" src="/Public/datepicker/datepicker_zh-cn.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>

    <style>
        .current{padding: 5px;margin: 3px;background: #F00;color:#FFF;font-weight: bold; }
        .num{padding: 5px;border: 1px solid #F00;margin: 3px;}
    </style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo ($pageurl); ?>"><?php echo ($pagebtn); ?></a></span>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($pagetitle); ?> </span>
    <div style="clear:both"></div>
</h1>

<div class="form-div">
    <form action="" name="searchForm">
        <p><input type="hidden" name="p" value="1"></p>
        <p>商品名称:<input type="text" name="goods_name" value="<?php echo I('get.goods_name');?>"></p>
        <p>价&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp格:<input type="text" name="start_price" value="<?php echo I('get.start_price');?>">--<input type="text" name="end_price" value="<?php echo I('get.end_price');?>"></p>
        <p>添加时间:<input type="text" size="8" id="start_addtime" name="start_addtime" value="<?php echo I('get.start_addtime');?>">--
        <input type="text" size="8" id="end_addtime" name="end_addtime" value="<?php echo I('get.end_addtime');?>"></p>
        <p>是否上架:<input type="radio" name="is_on_sale" value="-1" <?php if (I('get.is_on_sale',-1) == -1) echo 'checked="checked"';?> />全部
        <input type="radio" name="is_on_sale" value="1" <?php if (I('get.is_on_sale',-1) == 1) echo 'checked="checked"';?> />是
        <input type="radio" name="is_on_sale" value="0" <?php if (I('get.is_on_sale',-1) == 0) echo 'checked="checked"';?> />否</p>

        <p>是否删除:<input type="radio" name="is_detele" value="-1" <?php if (I('get.is_detele',-1) == -1) echo 'checked="checked"';?> />全部
        <input type="radio" name="is_detele" value="1" <?php if (I('get.is_detele',-1) == 1) echo 'checked="checked"';?> />是
        <input type="radio" name="is_detele" value="0" <?php if (I('get.is_detele',-1) == 0) echo 'checked="checked"';?> />否</p>

        <p>排序方式:<input type="radio" name="odby" value="id_asc" <?php if (I('get.odby','id_asc') == 'id_asc') echo 'checked="checked"';?> />根据添加id升序排序
        <input type="radio" name="odby" value="id_desc" <?php if (I('get.odby','id_asc') == 'id_desc') echo 'checked="checked"';?> />根据添加id降序排序
        <input type="radio" name="odby" value="price_asc" <?php if (I('get.odby','id_asc') == 'price_asc') echo 'checked="checked"';?>/>根据添加价格升序排序
        <input type="radio" name="odby" value="price_desc" <?php if (I('get.odby','id_asc') == 'price_desc') echo 'checked="checked"';?> />根据添加降序升序排序</p>

        <input type="submit" value="提交"><br>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
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
                <div >
                    <?php echo ($page); ?>
                </div>
            </td>
            </tr>
        </table>

    </div>
</form>


</body>
</html>
<script>
    $("#start_addtime").datepicker({dateFormat:'yy-mm-dd'});
    $("#end_addtime").datepicker({dateFormat:'yy-mm-dd'});
</script>
<div id="footer">
    曾焕新
</div>