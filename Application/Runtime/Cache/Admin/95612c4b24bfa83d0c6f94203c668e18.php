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
    <form name="main_form" method="POST" action="/index.php/Admin/Category/add.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">上级权限：</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级权限</option>
						<?php foreach ($parentData as $k => $v): ?>						<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['cat_name']; ?></option>
						<?php endforeach; ?>					</select>
				</td>
			</tr>
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input  type="text" name="cat_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">筛选属性：</td>
                <td>
                    <ul>
                        <li>
                            <a href="javascript:void(0)" onclick="addnew(this)">[+]</a>
                            <select name="type_id[]">
                                <option value="">选择类型</option>
                                <?php if(is_array($typeData)): $i = 0; $__LIST__ = $typeData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <select name="attr_id[]">
                                <option value="">选择属性</option>
                            </select>
                        </li>
                    </ul>
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
<script type="text/javascript">

    $("select[name='type_id[]']").change(function () {
        //获取选择的类型id
        var _this = $(this);
        var typeid = $(this).val();
        var opt = "<option value=''>选择属性</option>"
        //如果选中了一个类型就执行ajax取出这个类型下的属性
        if(typeid!=''){
            $.ajax({
                type:'GET',
                url:"<?php echo U('Admin/Goods/ajaxGetAttr','',false);?>/type_id/"+typeid,
                dataType:'json',
                success:function (data) {
                    //把返回的属性放到属性下拉框中
                    $(data).each(function (k,v) {
                        opt += "<option value='"+v.id+"'>"+v.attr_name+"</option>";
                    });
                    //放到属性的下拉框中
                    _this.next('select').html(opt);
                }
            })
        }
        else {
            _this.next('select').html(opt);
        }
    });

    function addnew(a) {
        var li = $(a).parent();
        if($(a).html() == "[+]"){
            var newli  = li.clone(true);//加true深度克隆，连js时间也克隆
            newli.find('a').html("[-]");
            li.after(newli);
        }else
            li.remove();
    }
</script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>