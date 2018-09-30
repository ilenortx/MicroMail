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
    <div type="text/html" id="orderTableToolbar">
		<div class="layui-form toolbar">
			<div class="layui-input-block">
				付款时间：
				<div class="layui-input-inline">
					<input type="text" class="layui-input qtime" readonly id="qpaytime" placeholder=" - " />
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;订单号：
				<div class="layui-input-inline">
					<input type="text" class="layui-input qorder" id="qorderSn" placeholder="订单号" />
				</div>
				<button class="layui-btn btna" onclick="reloadProList();" data-type="reload">查询</button>
			</div>
			<a class="layui-btn-warm btna ostatus" onclick="rqStatus(this, 'all')">全部</a>
			<a class="btna ostatus" onclick="rqStatus(this, 10)">待付款</a>
			<a class="btna ostatus" onclick="rqStatus(this, 20)">待发货</a>
			<a class="btna ostatus" onclick="rqStatus(this, 30)">待收货</a>
			<a class="btna ostatus" onclick="rqStatus(this, 50)">完成</a>
			<a class="btna ostatus" onclick="rqStatus(this, 'all')">售后</a>

            <div class="order_extra_btn">
                <div class="order_extra_action print_logistics">打印快递单</div>
                <div class="order_extra_action print_order">打印出货单</div>
            </div>
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