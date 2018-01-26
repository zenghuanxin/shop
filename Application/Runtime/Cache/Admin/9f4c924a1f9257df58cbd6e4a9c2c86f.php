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

<!-- 列表 -->
<div class="list-div" id="listDiv">
    <form action="/index.php/Admin/Goods/goodsNum/id/31.html" method="post">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><th><?php echo ($vo[0]['attr_name']); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
           <th width="250">库存</th>
           <th width="200">操作</th>
        </tr>
        <?php if(!empty($gnData)): if(is_array($gnData)): $i = 0; $__LIST__ = $gnData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gn): $mod = ($i % 2 );++$i; if($key==0) $opt='+'; else $opt='-'; ?>
        <tr>
            <?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td>
                    <select name='goods_attr_id[]'>
                        <option value="">请选择</option>
                        <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i; if(strpos(','.$gn['goods_attr_id'].',',','.$vo1['id'].',')!==false) $select = 'selected = "selected"'; else $select = ''; ?>
                            <option value="<?php echo ($vo1["id"]); ?>" <?php echo ($select); ?>><?php echo ($vo1["attr_value"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td><?php endforeach; endif; else: echo "" ;endif; ?>
            <td><input type="text" name="goods_num[]" value="<?php echo ($gn["goods_number"]); ?>"/></td>
            <td><input onclick="addnew(this)" type="button" value="<?php echo ($opt); ?>"/></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php else: ?>
            <tr>
                <?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td>
                        <select name='goods_attr_id[]'>
                            <option value="">请选择</option>
                            <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i; if(strpos(','.$gn['goods_attr_id'].',',','.$vo1['id'].',')!==false) $select = 'selected = "selected"'; else $select = ''; ?>
                                <option value="<?php echo ($vo1["id"]); ?>" <?php echo ($select); ?>><?php echo ($vo1["attr_value"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td><?php endforeach; endif; else: echo "" ;endif; ?>
                <td><input type="text" name="goods_num[]" value="<?php echo ($gn["goods_number"]); ?>"/></td>
                <td><input onclick="addnew(this)" type="button" value="+"/></td>
            </tr><?php endif; ?>
        <tr class="inputbut">
            <td colspan="<?php echo count($attr)+2;?>" align="center">
                <input type="submit" value="提交"/>
            </td>
        </tr>

	</table>
    </form>
</div>
<script>
$('#addtimefrom').datepicker(); $('#addtimeto').datepicker();

//点击加号赋值一行库存
function addnew(btn) {
    //获取点击按钮所在tr
    var tr = $(btn).parent().parent();
    if ($(btn).val()=='+'){
        //克隆tr
        var newtr = tr.clone();
        //把+变成-
        newtr.find(':button').val('-')
        //把tr加到table中
        $('.inputbut').before(newtr);
    }else {
        tr.remove();
    }


}

</script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>