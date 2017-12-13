<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>商品列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
    <link href="/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="javascript" src="/Public/datepicker/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/datepicker/datepicker_zh-cn.js"></script>
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


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Role/add.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">

            <tr>
                <td class="label">角色名称：</td>
                <td>
                    <input  type="text" name="role_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表：</td>
                <td>
                <?php if(is_array($priData)): $i = 0; $__LIST__ = $priData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo str_repeat('-',$vo['level']*8);?>
                        <input level=<?php echo ($vo['level']); ?> type="checkbox" name="pri_id[]" value="<?php echo ($vo["id"]); ?>" /><?php echo ($vo["pri_name"]); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>

            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    // 让提交只能点一次
    $(":submit").click(function(){
        var sec = 3;
        $(this).attr('disabled', 'disabled');
        $(this).val(sec + "秒之后提交");
        var _this = $(this);
        setInterval(function(){
            if(--sec == 0)
                $("form[name=main_form]").submit();
            else
                _this.val(sec + "秒之后提交");
            _this.val();
        }, 1000);
    });

    // 为所有的选择框绑定点击事件
    $(":checkbox").click(function(){
        // 先取出当前权限的level值是多少
        var cur_level = $(this).attr('level');
        //判断是否选中
        if ($(this).attr('checked')){
            //
            var temlevel = cur_level;//给一个临时的变量后面要进行减操作
            var allprev = $(this).prevAll(':checkbox');
            $(allprev).each(function (k,v) {
                if ($(v).attr('level') < temlevel) {
                    temlevel--;
                    $(v).attr("checked", "checked");
                }

            });

            var allnext = $(this).nextAll(':checkbox');
            $(allnext).each(function (k,v) {
               if ($(v).attr('level') > cur_level)
                   $(v).attr('checked','checked');
               else
                   return false;
            });
        }else {

            var allnext = $(this).nextAll(':checkbox');
            $(allnext).each(function (k,v) {
                if ($(v).attr('level') > cur_level){
                    $(v).removeAttr('checked');
                }else {
                    return false;
                }
            });
        }
    });
</script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>