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

<!-- 搜索 -->
<div class="form-div search_form_div">
    <form method="GET" name="search_form">
		<p>
			商品名称：
	   		<input type="text" name="goods_name" size="30" value="<?php echo I('get.goods_name'); ?>" />
		</p>
		<p>
			主分类的id：
	   		<input type="text" name="cat_id" size="30" value="<?php echo I('get.cat_id'); ?>" />
		</p>
		<p>
			品牌的id：
	   		<input type="text" name="brand_id" size="30" value="<?php echo I('get.brand_id'); ?>" />
		</p>
		<p>
			本店价：
	   		从 <input id="shop_pricefrom" type="text" name="shop_pricefrom" size="15" value="<?php echo I('get.shop_pricefrom'); ?>" /> 
		    到 <input id="shop_priceto" type="text" name="shop_priceto" size="15" value="<?php echo I('get.shop_priceto'); ?>" />
		</p>
		<p>
			是否热卖：
			<input type="radio" value="-1" name="is_hot" <?php if(I('get.is_hot', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_hot" <?php if(I('get.is_hot', -1) == '1') echo 'checked="checked"'; ?> /> 是 
			<input type="radio" value="0" name="is_hot" <?php if(I('get.is_hot', -1) == '0') echo 'checked="checked"'; ?> /> 否 
		</p>
		<p>
			是否新品：
			<input type="radio" value="-1" name="is_new" <?php if(I('get.is_new', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_new" <?php if(I('get.is_new', -1) == '1') echo 'checked="checked"'; ?> /> 是 
			<input type="radio" value="0" name="is_new" <?php if(I('get.is_new', -1) == '0') echo 'checked="checked"'; ?> /> 否 
		</p>
		<p>
			是否精品：
			<input type="radio" value="-1" name="is_best" <?php if(I('get.is_best', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_best" <?php if(I('get.is_best', -1) == '1') echo 'checked="checked"'; ?> /> 是 
			<input type="radio" value="0" name="is_best" <?php if(I('get.is_best', -1) == '0') echo 'checked="checked"'; ?> /> 否 
		</p>
		<p>
			是否上架：
			<input type="radio" value="-1" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="1" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '1') echo 'checked="checked"'; ?> /> 上架 
			<input type="radio" value="0" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '0') echo 'checked="checked"'; ?> /> 下架 
		</p>
		<p>
			商品类型id：
	   		<input type="text" name="type_id" size="30" value="<?php echo I('get.type_id'); ?>" />
		</p>
		<p>
			添加时间：
	   		从 <input id="addtimefrom" type="text" name="addtimefrom" size="15" value="<?php echo I('get.addtimefrom'); ?>" /> 
		    到 <input id="addtimeto" type="text" name="addtimeto" size="15" value="<?php echo I('get.addtimeto'); ?>" />
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >商品名称</th>
            <th >市场价</th>
            <th >本店价</th>
            <th >logo</th>
            <th >热卖</th>
            <th >新品</th>
            <th >精品</th>
            <th >上架</th>
			<th >库存</th>
            <th >排序</th>
			<th width="200">操作</th>
        </tr>
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tron" align="center">
				<td><?php echo ($vo["goods_name"]); ?></td>
				<td><?php echo ($vo["market_price"]); ?></td>
				<td><?php echo ($vo["shop_price"]); ?></td>
				<td><?php showImage($vo['sm_logo'])?></td>
				<td><?php if(($vo["is_hot"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></td>
				<td><?php if(($vo["is_new"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></td>
				<td><?php if(($vo["is_best"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></td>
				<td><?php if(($vo["is_on_sale"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></td>
				<td><?php echo ($vo["num"]); ?></td>
				<td><?php echo ($vo["sort_num"]); ?></td>
		        <td align="center">
					<a href="<?php echo U('goodsNum?id='.$vo['id'].'&p='.I('get.p')); ?>" title="库存">库存</a> |
		        	<a href="<?php echo U('edit?id='.$vo['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('recycle?id='.$vo['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要加入回收站吗？');" title="加入回收站">加入回收站</a>
		        </td>
	        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
$('#addtimefrom').datepicker(); $('#addtimeto').datepicker(); </script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>