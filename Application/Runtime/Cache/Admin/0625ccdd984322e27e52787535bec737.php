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

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form method="post" action="/index.php/Admin/Goods/goodsAdd.html" enctype="multipart/form-data" name = 'goods_form'>
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
    </div>
</div>


</body>
</html>
<script>
    //为表单绑定ajax提交的事件
    //    $("form[name=goods_form]").submit(function () {
    //        $.ajax({
    //            type:"POST",
    //            url:"/index.php/Admin/Goods/goodsAdd.html",
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
<div id="footer">
    曾焕新
</div>