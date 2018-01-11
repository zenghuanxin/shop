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

<style>
    ul#pics_ul li{list-style-type:none;float:left;margin:5px;height:180px;}
</style>
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">基本信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form name="main_form" method="POST" action="/index.php/Admin/Goods/edit/id/34.html" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
            <input type="hidden" name="old_type_id" value="<?php echo ($data["type_id"]); ?>" />
            <!-- 基本信息 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">商品名称：</td>
                    <td>
                        <input size="60" type="text" name="goods_name" value="<?php echo ($data["goods_name"]); ?>" />
                        <span class="required">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cat_id">
                            <option value="">选择分类</option>
                            <?php foreach ($catData as $k => $v): if($v['id'] == $data['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-',$v['level'] * 8); echo ($v["cat_name"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="required">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">扩展分类：</td>
                    <td>
                        <input onclick="$(this).parent().append($(this).next('select').clone());" type="button" value="添加" />
                        <?php
 foreach ($extCatId as $k1 => $v1): ?>
                        <select name="ext_cat_id[]">
                            <option value="">选择分类</option>
                            <?php foreach ($catData as $k => $v): if($v['id'] == $v1['cat_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-',$v['level'] * 8); echo ($v["cat_name"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌：</td>
                    <td>
                        <select name="brand_id">
                            <option value="">选择品牌</option>
                            <?php foreach ($brandData as $k => $v): if($v['id'] == $data['brand_id']) $select = 'selected="selected"'; else $select = ''; ?>
                            <option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["brand_name"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场价：</td>
                    <td>
                        ￥ <input  type="text" size="10" name="market_price" value="<?php echo ($data["market_price"]); ?>" /> 元
                    </td>
                </tr>
                <tr>
                    <td class="label">本店价：</td>
                    <td>
                        ￥ <input  type="text" size="10" name="shop_price" value="<?php echo ($data["shop_price"]); ?>" /> 元
                    </td>
                </tr>
                <tr>
                    <td class="label">赠送积分：</td>
                    <td>
                        <input  type="text" name="jifen" value="<?php echo ($data["jifen"]); ?>" />
                        如果不填和商品价格相同
                    </td>
                </tr>
                <tr>
                    <td class="label">赠送经验值：</td>
                    <td>
                        <input  type="text" name="jyz" value="<?php echo ($data["jyz"]); ?>" />
                        如果不填和商品价格相同
                    </td>
                </tr>
                <tr>
                    <td class="label">如果要用积分兑换，需要的积分数：</td>
                    <td>
                        <input  type="text" name="jifen_price" value="<?php echo ($data["jifen_price"]); ?>" />
                        如果不填代表不能使用积分兑换
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <input <?php if($data['is_promote'] == 1) echo 'checked="checked"'; ?> value="1" name="is_promote" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled', 'disabled');" type="checkbox" />促销价：</td>
                    <td>
                        ￥<input class="promote_price" <?php if($data['is_promote']==0) echo 'disabled="disabled"'; ?> type="text" name="promote_price" value="<?php echo ($data["promote_price"]); ?>"  size = 10/>元
                    </td>
                </tr>
                <tr>
                    <td class="label">促销开始时间：</td>
                    <td>
                        <input class="promote_price" <?php if($data['is_promote']==0) echo 'disabled="disabled"'; ?> id="promote_start_time" type="text" name="promote_start_time" value="<?php if($data['promote_start_time']) echo date('Y-m-d H:i', $data['promote_start_time']); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">促销结束时间：</td>
                    <td>
                        <input class="promote_price" <?php if($data['is_promote']==0) echo 'disabled="disabled"'; ?> id="promote_end_time" type="text" name="promote_end_time" value="<?php if($data['promote_end_time']) echo date('Y-m-d H:i', $data['promote_end_time']); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">logo原图：</td>
                    <td>
                        <?php showImage($data['sm_logo']); ?><br />
                        <input type="file" name="logo" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="1" <?php if(($data["is_hot"]) == "1"): ?>checked='checked'<?php endif; ?> />是
                        <input type="radio" name="is_hot" value="0" <?php if(($data["is_hot"]) == "0"): ?>checked='checked'<?php endif; ?> />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="1" <?php if(($data["is_new"]) == "1"): ?>checked='checked'<?php endif; ?> />是
                        <input type="radio" name="is_new" value="0" <?php if(($data["is_new"]) == "0"): ?>checked='checked'<?php endif; ?> />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="1" <?php if(($data["is_best"]) == "1"): ?>checked='checked'<?php endif; ?> />是
                        <input type="radio" name="is_best" value="0"  <?php if(($data["is_best"]) == "0"): ?>checked='checked'<?php endif; ?> />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1" <?php if(($data["is_on_sale"]) == "1"): ?>checked='checked'<?php endif; ?> />上架
                        <input type="radio" name="is_on_sale" value="0" <?php if(($data["is_on_sale"]) == "0"): ?>checked='checked'<?php endif; ?> />下架
                    </td>
                </tr>
                <tr>
                    <td class="label">seo优化_关键字：</td>
                    <td>
                        <input size="60" type="text" name="seo_keyword" value="<?php echo ($data["seo_keyword"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">seo优化_描述：</td>
                    <td>
                        <input size="60" type="text" name="seo_description" value="<?php echo ($data["seo_description"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="label">排序数字：</td>
                    <td>
                        <input size="5" type="text" name="sort_num" value="<?php echo ($data["sort_num"]); ?>" />
                    </td>
                </tr>
            </table>
            <!-- 描述 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"><?php echo ($data["goods_desc"]); ?></textarea>
                    </td>
                </tr>
            </table>
            <!-- 会员价格 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr><td style="font-size:18px;font-weight:bold;">会员价格（如果没有填会员价格就按折扣率计算价格，如果填了就按填的价格算，不再打折）</td></tr>
                <?php
 foreach ($mlData as $k => $v): ?>
                <tr>
                    <td>
                        <?php echo ($v["id"]); ?> - <?php echo ($v["level_name"]); ?>（<?php echo $v['rate']/10; ?> 折） ：
                        ￥<input type="text" size="10" name="mp[<?php echo ($v["id"]); ?>]" value="<?php echo ($mpData[$v['id']]); ?>" /> 元
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <!-- 属性 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr><td>
                    商品类型：<select name="type_id">
                    <option value="">选择类型</option>
                    <?php foreach ($typeData as $k => $v): if($v['id'] == $data['type_id']) $select = 'selected="selected"'; else $select = ''; ?>
                    <option <?php echo ($select); ?> value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                    <?php endforeach; ?>
                </select>
                </td></tr>
                <tr><td id="attr_container">
                    <?php
 $attrId = array(); foreach ($gaData as $k => $v): ?>
                    <p>
                        <?php echo $v['attr_name']; ?> ：
                        <?php if($v['attr_type'] == 1): if(in_array($v['attr_id'], $attrId)) $opt = '[-]'; else { $opt = '[+]'; $attrId[] = $v['attr_id']; } ?>
                        <a gaid="<?php echo ($v["id"]); ?>" onclick="addnew(this);" href="javascript:void(0);"><?php echo ($opt); ?></a>
                        <?php endif; ?>
                        <?php  if(empty($v['attr_value'])) $old_ = ''; else $old_ = 'old_'; if($v['attr_option_values']) { $_arr = explode(',', $v['attr_option_values']); echo '<select name="'.$old_.'ga['.$v['attr_id'].']['.$v['id'].']"><option value="">请选择</option>'; foreach ($_arr as $k1 => $v1) { if($v1 == $v['attr_value']) $select = 'selected="selected"'; else $select = ''; echo '<option '.$select.' value="'.$v1.'">'.$v1.'</option>'; } echo '</select>'; } else echo '<input name="'.$old_.'ga['.$v['attr_id'].']['.$v['id'].']" type="text" value="'.$v['attr_value'].'" />'; ?>
                        <?php if($v['attr_type'] == 1): ?>
                        ￥ <input name="old_attr_price[<?php echo ($v["attr_id"]); ?>][<?php echo ($v["id"]); ?>]" type="text" size="10" value="<?php echo ($v["attr_price"]); ?>" /> 元
                        <?php endif; ?>
                    </p>
                    <?php endforeach; ?>
                </td></tr>
            </table>
            <!-- 相册 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr><td><input onclick="$(this).parent().parent().parent().append('<tr><td><input type=\'file\' name=\'pics[]\' /></td></tr>');" type="button" value="添加一张图片" /></td></tr>
                <tr><td>
                    <ul id="pics_ul">
                        <?php foreach ($gpData as $k => $v): ?>
                        <li>
                            <input pic_id="<?php echo ($v["id"]); ?>" class="delimage" type="button" value="删除" /><br />
                            <?php showImage($v['sm_pic']); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </td></tr>
            </table>
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script>
    // 点击按钮切换table
    $("div#tabbar-div p span").click(function(){
        // 获取点击的是第几个按钮
        var i = $(this).index();
        // 显示第i个table
        $(".table_content").eq(i).show();
        // 隐藏其他的table
        $(".table_content").eq(i).siblings(".table_content").hide();
        // 把原来选中的取消选中状态
        $(".tab-front").removeClass("tab-front").addClass("tab-back");
        // 切换点击的按钮的样式为选中状态
        $(this).removeClass("tab-back").addClass("tab-front");
    });

    $("#promote_start_time").datepicker();
    $("#promote_end_time").datepicker();
    UE.getEditor('goods_desc', {
        "initialFrameWidth" : "100%",   // 宽
        "initialFrameHeight" : 400,      // 高
        "maximumWords" : 10000            // 最大可以输入的字符数量
    });

    // 当选择类型时执行AJAX取出类型的属性
    $("select[name=type_id]").change(function(){
        // 获取选中的类型的id
        var type_id = $(this).val();
        if(type_id != "")
        {
            $.ajax({
                type : "GET",
                // 大U生成的地址默认带后缀，如：/index.php/Admin/Goods/ajaxGetAttr.html/type_id/+type_id
                // 第三个参数就是去掉.html后缀否则TP会报错
                url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+type_id,
                dataType : "json",
                success : function(data)
                {
                    var html = "";
                    // 循环服务器返回的属性的JSON数据
                    $(data).each(function(k,v){
                        html += "<p>";
                        html += v.attr_name + " : ";
                        // 根据属性的类型生成不同的表单元素：
                        // 1. 如果属性是可选的那么就有一个+号
                        // 2. 如果属性有可选值就是一个下拉框
                        // 3. 如果属性是唯一的就生成一个文本框
                        if(v.attr_type == 1)
                            html += " <a onclick='addnew(this);' href='javascript:void(0);'>[+]</a> ";
                        // 判断是否有可选值
                        if(v.attr_option_values == "")
                            html += "<input type='text' name='ga["+v.id+"][]' />";
                        else
                        {
                            // 先把可选值转化成数组
                            var _attr = v.attr_option_values.split(",");
                            html += "<select name='ga["+v.id+"][]'>";
                            html += "<option value=''>请选择</option>";
                            // 循环每个可选值构造option
                            for(var i=0; i<_attr.length; i++)
                            {
                                html += "<option value='"+_attr[i]+"'>"+_attr[i]+"</option>";
                            }
                            html += "</select>";
                        }
                        if(v.attr_type == 1)
                            html += " 属性价格：￥ <input size='8' name='attr_price["+v.id+"][]' type='text' /> 元";
                        html += "</p>";
                    });
                    $("#attr_container").html(html);
                }
            });
        }
        else
            $("#attr_container").html("");
    });

    // 点击+号
    function addnew(a)
    {
        // 选中a标签所在的p标签
        var p = $(a).parent();
        // 先获取A标签中的内容
        if($(a).html() == "[+]")
        {
            // 把p克隆一份
            var newP = p.clone();
            // 先取出名称的字符串
            var oldName = newP.find("select").attr("name");
            // 把名称中的old_去掉
            var newName = oldName.replace("old_", "");
            // 把新的名称设置回去
            newP.find("select").attr("name", newName);
            // 把属性价格的名称也去掉old_
            var oldName = newP.find("input").attr("name");
            var newName = oldName.replace("old_", "");
            newP.find("input").attr("name", newName);
            // 把克隆出来的P里面的a标签变成-号
            newP.find("a").html("[-]");
            // 放在后面
            p.after(newP);
        }
        else
        {
            // 点击了[-]号
            if(confirm("确定要删除吗？"))
            {
                // 先获取这条记录的id
                var gaid = $(a).attr("gaid");
                $.get("<?php echo U('ajaxDelGoodsAttr', '', FALSE); ?>/gaid/"+gaid, function(data){
                    p.remove();
                });
            }
        }
    }
    // 删除图片
    $(".delimage").click(function(){
        if(confirm("确定要删除吗？"))
        {
            // 获取图片的ID
            var pic_id = $(this).attr("pic_id");
            // 取出图片所在的LI标签
            var li = $(this).parent();
            $.ajax({
                type : "GET",
                url : "<?php echo U('ajaxDelImage', '', FALSE); ?>/pic_id/"+pic_id,
                success : function(data)
                {
                    // ajax请求成功之后再把图片人页面上删除
                    li.remove();
                }
            });

        }
    });
    // 判断如果现在没有属性就直接触发AJAX事件获取属性的数据
    <?php if(empty($gaData)): ?>
    $("select[name=type_id]").trigger("change");
    <?php endif; ?>
</script>















<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>