<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" language="JavaScript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
    <title>Title</title>
</head>
<body>
<form method="post" action="/index.php/Admin/Goods/edit/id/2/p/1.html" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
    商品名称：<input type="text" name="goods_name" value="<?php echo ($info["goods_name"]); ?>"/><br>
    商品价格：<input type="text" name="price" value="<?php echo ($info["price"]); ?>"/><br>
    <img src="/Public/Uploads/<?php echo ($info["sm_logo"]); ?>" /><br>
    商品logo：<input type="file" name="logo"/><br>
    商品描述：<textarea name="goods_desc" id="goods_desc"><?php echo ($info["goods_desc"]); ?></textarea>
    <br>
    是否上架：
    <input type="radio" name="is_on_sale" value="1"<?php if($info['is_on_sale']==1) echo 'checked="checked"'?> />上架
    <input type="radio" name="is_on_sale" value="0"<?php if($info['is_on_sale']==0) echo 'checked="checked"'?> />下架
    <br>
    <input type="submit" value="提交">
</form>
</body>
<div id="footer">
    曾焕新
</div>
</html>
<script>
    UE.getEditor('goods_desc', {
        "initialFrameWidth" : "50%",//宽
        "initialFrameHeight" : 350,//高
        "maximumWords" : 50000,//最多可以输入的字符数

    });

</script>