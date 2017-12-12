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

<!-- 搜索 -->
<div class="form-div search_form_div">
    <form method="GET" name="search_form">
		<p>
			账号：
	   		<input type="text" name="username" size="30" value="<?php echo I('get.username'); ?>" />
		</p>
		<p>
			是否启用：
			<input type="radio" value="-1" name="is_use" <?php if(I('get.is_use', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_use" <?php if(I('get.is_use', -1) == '1') echo 'checked="checked"'; ?> /> 启用 
			<input type="radio" value="0" name="is_use" <?php if(I('get.is_use', -1) == '0') echo 'checked="checked"'; ?> /> 禁用 
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >账号</th>
            <th >密码</th>
            <th >是否启用  1：启用 0：禁用</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['username']; ?></td>
				<td><?php echo $v['password']; ?></td>
				<td><?php echo $v['is_use']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
</script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>