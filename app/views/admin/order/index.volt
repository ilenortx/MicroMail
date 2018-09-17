<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/respond.min.js"></script>
    <![endif]-->
    
	{{ assets.outputCss() }}
	{{ assets.outputJs() }}
        
    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    

    <title>全部订单</title>
</head>
<body style="min-height:auto">
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 全部订单 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    <!--<div>-->
        <!--<div class="aaa_pts_4"><a href="{:U('order_count')}?shop_id={$shop_id}" class="btn btn-success">销售统计</a></div>-->

    <!--</div>-->
    <!--<br>-->
    <!--<div style="border-bottom:1px solid #333;"></div>-->
    <!--<br>-->
    <!-- <form name='form' action="{:U('index')}" method='get'>
        <div class="pro_4 bord_1">
            <div class="pro_5">
                支付类型：
                <select class="inp_1 inp_6" name="pay_type" id="type">
                    <option value="">全部类型</option>
                    <option value="weixin" <?php echo $pay_type=='weixin' ? 'selected="selected"' : NULL ?>>微信支付</option>
                    <option value="cash" <?php echo $pay_type=='cash' ? 'selected="selected"' : NULL ?>>现金支付</option>
                </select>
            </div>

            <div class="pro_5">
                订单状态：
                <select class="inp_1 inp_6" name="pay_status" id="status">
                    <option value="">全部状态</option>
                    <?php foreach ($order_status as $key => $val) { ?>
                    <option value="<?php echo $key; ?>" <?php if ($pay_status==$key) { ?>selected="selected"<?php } ?> ><?php echo $val; ?></option>
                    <?php } ?>
                    <option value="1" <?php if ($pay_status==1) { ?>selected="selected"<?php } ?> >退款中</option>
                    <option value="2" <?php if ($pay_status==2) { ?>selected="selected"<?php } ?> >已退款</option>
                </select>
            </div>

            <div class="pro_5">
                购买时间：
                <input class="inp_1 inp_6" id="start_time" name="start_time" value="<?php echo $start_time ?>" onfocus="MyCalendar.SetDate(this)">
                <input class="inp_1 inp_6" id="end_time" name="end_time" value="<?php echo $end_time ?>" onfocus="MyCalendar.SetDate(this)">
                <input class="btn btn-success" type="button"  value="搜 索" style="margin-left: 20px;" onclick="product_option();">
            </div>
            <div class="pro_6">


            </div>
        </div>
    </form>
    <br>
-->
    <script type="text/html" id="orderTableToolbar">
		<div class="toolbar">
			<!--<a class="btna" onclick="openEditFull('添加商品','../Product/paPage')">
			    <i class="layui-icon">&#xe654;</i>添加
			 </a>-->
		</div>
	</script>
	<div class="layui-row" id="noteGrade" style="display: none;">
		<div class="layui-form">
			<label class="layui-form-label">备注等级</label>
			<input type="radio" name="grade" value="0" title="<img src='../img/common/note/note_gray.png' title='无等级'>" />
			<input type="radio" name="grade" value="1" title="<img src='../img/common/note/note_red.png' title='等级一'>" />
			<input type="radio" name="grade" value="2" title="<img src='../img/common/note/note_yellow.png' title='等级二'>" />
			<input type="radio" name="grade" value="3" title="<img src='../img/common/note/note_green.png' title='等级三'>" />
			<input type="radio" name="grade" value="4" title="<img src='../img/common/note/note_blue.png' title='等级四'>" />
			<input type="radio" name="grade" value="5" title="<img src='../img/common/note/note_purple.png' title='等级五'>" />
			<textarea class="order_note_context" placeholder="备注信息"></textarea>
			<button class="renote layui-btn layui-btn-primary layui-btn-sm">提  交</button>
		</div>
	</div>
    <table id="order-table" class="layui-hide" lay-filter='order'></table>
    <!-- <table id="orderList" class="table table-border table-bordered table-bg">
        <thead>
	        <tr class="text-c">
	            <th width="40">订单ID</th>
	            <th width="100">买家</th>
	            <th width="130">订单号</th>
	            <th width="60">总金额(提成前)</th>
	            <th width="60">分销商提成</th>
	            <th width="60">总金额(提成后)</th>
	            <th width="40">支付类型</th>
	            <th width="40">订单状态</th>
	            <th width="100">订单时间</th>
	            <th width="100">备注</th>
	            <th width="60">操作</th>
	        </tr>
        </thead>

        {% for list in orderlist %}
            <tr data-id="{{ list['id'] }}" data-name="{{ list['name'] }}" class="text-c">
                <td>{{ list['id'] }}</td>
                <td>{{ list['name'] }}</td>
                <td>{{ list['order'] }}</td>
                <td>{{ list['price_h'] }}</td>
                <td>{{ list['fxtc'] }}</td>
                <td>{{ list['price_h']-list['fxtc'] }}</td>
                <td>{% if list['type']=='alipay' %}支付宝{% elseif list['type']=='weixin' %}微信支付{% else %}货到付款{% endif %}</td>
                <td class="status">
                    {% if list['back']==1 %}
                    	<font style="color:red">申请退款</font>
                    {% elseif list['back']==2 %}
                    	<font style="color:#900">已退款</font>
                    {% else %}
                        <font class='font_color'>{{ order_status[list['status']] }}</font>
                    {% endif %}
                </td>
                <td>{{ list['addtime'] }}</td>
                <td>{{ list['note'] }}</td>
                <td>
                    <a href="../Order/showPage?oid={{ list['id'] }}">查看</a>
                     | <a onclick="del_id_url({{ list['id'] }})">删除</a>
                    {% if list['back']==1 %} | <a href="{:U('back')}?oid={{ list['id'] }}">确认退款</a>{% endif %}
                </td>
            </tr>
        {% endfor %}
    </table> -->
</div>

</body>
</html>