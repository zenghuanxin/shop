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

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form name="main_form" method="POST" action="/index.php/Admin/Goods/add.html" enctype="multipart/form-data">
            <table class="table-content" cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">商品名称：</td>
                    <td>
                        <input  size="60" type="text" name="goods_name" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cat_id">
                            <option value="">选择分类</option>
                            <?php if(is_array($catData)): $i = 0; $__LIST__ = $catData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo str_repeat('-',$vo['level'] * 8); echo ($vo["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span class="required">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">扩展分类：</td>
                    <td>
                        <input type="button" value="添加" onclick="$(this).parent().append($(this).next('select').clone());"/>
                        <select name="ext_cat_id[]">
                            <option value="">选择分类</option>
                            <?php if(is_array($catData)): $i = 0; $__LIST__ = $catData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo str_repeat('-',$vo['level'] * 8); echo ($vo["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span class="required">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌：</td>
                    <td>
                        <select name="brand_id">
                            <option value="">选择品牌</option>
                            <?php if(is_array($brandData)): $i = 0; $__LIST__ = $brandData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["brand_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场价：</td>
                    <td>
                        ￥<input size="10" type="text" name="market_price" value="0.00" />元
                    </td>
                </tr>
                <tr>
                    <td class="label">本店价：</td>
                    <td>
                        ￥<input size="10" type="text" name="shop_price" value="0.00" />元
                    </td>
                </tr>
                <tr>
                    <td class="label">赠送积分：</td>
                    <td>
                        &nbsp;<input  size="10" type="text" name="jifen" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label">赠送经验值：</td>
                    <td>
                        &nbsp;<input size="10" type="text" name="jyz" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label">如果要用积分兑换，需要的积分数：</td>
                    <td>
                        &nbsp;<input size="10" type="text" name="jifen_price" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label"><input value="1" name="is_promote" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled', 'disabled');" type="checkbox" />促销价：</td>
                    <td>
                        <input class="promote_price" disabled="disabled" type="text" name="promote_price" value="0.00" />
                    </td>
                </tr>
                <tr>
                    <td class="label">促销开始时间：</td>
                    <td>
                        <input class="promote_price" disabled="disabled" id="promote_start_time" type="text" name="promote_start_time" />
                    </td>
                </tr>
                <tr>
                    <td class="label">促销结束时间：</td>
                    <td>
                        <input class="promote_price" disabled="disabled" id="promote_end_time" type="text" name="promote_end_time" />
                    </td>
                </tr>
                <tr>
                    <td class="label">logo原图：</td>
                    <td>
                        <input type="file" name="logo" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="1"  />是
                        <input type="radio" name="is_hot" value="0" checked="checked" />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="1"  />是
                        <input type="radio" name="is_new" value="0" checked="checked" />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="1"  />是
                        <input type="radio" name="is_best" value="0" checked="checked" />否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1" checked="checked" />上架
                        <input type="radio" name="is_on_sale" value="0"  />下架
                    </td>
                </tr>
                <tr>
                    <td class="label">seo优化_关键字：</td>
                    <td>
                        <input size="60" type="text" name="seo_keyword" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label">seo优化_描述：</td>
                    <td>
                        <input size="60" type="text" name="seo_description" value="" />
                    </td>
                </tr>

                <tr>
                    <td class="label">排序数字：</td>
                    <td>
                        <input size="5" type="text" name="sort_num" value="100" />
                    </td>
                </tr>

                <tr>
                    <td colspan="99" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
            <table class="table-content" cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="99" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
            <table class="table-content" cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr><td>会员价格(如果没有设置会员价格，那么就按这个会员级别的折扣率来计算价格)</td></tr>
                <?php if(is_array($memData)): $i = 0; $__LIST__ = $memData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["level_name"]); ?>(<?php echo ($vo['rate']/10); ?>折) : ￥<input size="10" type="text" name="mp[<?php echo ($vo["id"]); ?>]"/>元</td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td colspan="99" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
            <table class="table-content" cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr>
                    <td class="label">商品类型：</td>
                    <td>
                        <select name="type_id">
                            <option value="">请选择类型</option>
                            <?php if(is_array($typeData)): $i = 0; $__LIST__ = $typeData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" style="width: 50px;"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr><td class="attr_container"></td></tr>
                <tr>
                    <td colspan="99" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
            <table class="table-content" cellspacing="1" cellpadding="3" width="100%" style="display: none">
                <tr><td><input onclick="$(this).parent().parent().parent().append('<tr><td><input type=\'file\' name=\'pics[]\' /></td></tr>');" type="button" value="添加一张图片" /></td></tr>

            </table>
        </form>
    </div>
</div>
<script>
    $("#promote_start_time").datepicker();
    $("#promote_end_time").datepicker();
    UE.getEditor('goods_desc', {
        "initialFrameWidth" : "100%",   // 宽
        "initialFrameHeight" : 200,      // 高
        "maximumWords" : 10000            // 最大可以输入的字符数量
    });
    $(function () {
        $('#tabbar-div p span').click(function () {
            //获取点击的是第几个按钮
            var i = $(this).index();
            //显示第I个table
            $('.table-content').eq(i).show();
            //隐藏其他的table
            $('.table-content').eq(i).siblings().hide();
            //把原来选中的取消选中状态
            $('.tab-front').removeClass('tab-front').addClass('tab-back');
            //切换点击的按钮的样式为选中状态
            $(this).removeClass('tab-back').addClass('tab-front');

        });

        $('select[name=type_id]').change(function () {
            var type_id = $(this).val();
            if(type_id!='') {
                var url = "<?php echo U('ajaxGetAttr','',false);?>" + "/type_id/" + type_id;
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: url,
                    success: function (data) {
                        var html = '';
                        $(data).each(function (k, v) {
                            html += "<p>";
                            if (v.attr_type == 1) {
                                html += "<a onclick='addnewp(this)' href='javascript:void(0)'>[+]</a>";
                            }
                            html += v.attr_name + " ：";
                            if (v.attr_option_values == '') {
                                html += "<input type='text' name='ga["+v.id+"][]'/>";
                            } else {
                                var _attr = v.attr_option_values.split(',');
                                html += "<select name='ga["+v.id+"][]'>";
                                html += "<option value=''>请选择</option>";
                                for (var i = 0; i < _attr.length; i++) {
                                    html += "<option value='" + _attr[i] + "'>" + _attr[i] + "</option>";
                                }
                                html += "</select>";
                            }
                            if (v.attr_type==1)
                                html +="&nbsp;属性价格：￥"+"<input type='text' name='attr_price["+v.id+"][]' size='10'/>元";
                            html += "</p>";
                        });
                        $('.attr_container').html(html);
                    }
                });
            }else {
                $('.attr_container').html("");
            }
        });
    });
    function addnewp(a) {
        var flag = $(a).text();
        var p = $(a).parent();
        if (flag=="[+]"){
            //把p标签克隆一份
            var newp = p.clone();
            //把克隆的标签的【+】变成【-】
            newp.find("a").text("[-]");
            //添加到P后面
            p.after(newp);
        }else
            p.remove();
    }

</script>
<div id="footer">
    曾焕新
</div>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>