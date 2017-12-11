<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" language="JavaScript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
    <title>Title</title>
</head>
<body>
<form method="post" action="/index.php/Admin/Goods/add.html" enctype="multipart/form-data" name = 'goods_form'>
    商品名称：<input type="text" name="goods_name"/><br>
    商品价格：<input type="text" name="price"/><br>
    商品logo：<input type="file" name="logo"/><br>
    商品描述：<textarea name="goods_desc" id="goods_desc"></textarea><br>
    是否上架：
    <input type="radio" name="is_on_sale" value="1" checked="checked"/>上架
    <input type="radio" name="is_on_sale" value="0"/>下架
    <br>
    <input type="submit" value="提交">
</form>
</body>
</html>
<script>
    //为表单绑定ajax提交的事件
//    $("form[name=goods_form]").submit(function () {
//        $.ajax({
//            type:"POST",
//            url:"/index.php/Admin/Goods/add.html",
//            data:$(this).serialize(),//收集表单中的数据
//            dataType:'json',//标记服务器返回的是json数据
//            success:function (data) else {
//                    alert(data.info);
//                }
//            }
//        })
//
//        return false;
//    });

    UE.getEditor('goods_desc', {
        "initialFrameWidth" : "50%",//宽
        "initialFrameHeight" : 350,//高
        "maximumWords" : 50000,//最多可以输入的字符数

    });


</script>