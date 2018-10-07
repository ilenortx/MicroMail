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

    <title>出货</title>
    <style type="text/css">
    	.page-container{ margin: 0; }
    </style>
</head>

<body style="min-height:auto">
    <nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> <a href="../Order/index">全部订单</a> <span class="c-gray en">&gt;</span> 订单出货 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
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
    <div class="page-container">
    	<h3 data-v-814df97a="" class="out-title-first">1.确认订单基本信息</h3>
    	<div class="top-base-info-div">
    		<div class="top-div">
    			<div class="td-left">
    				<span>订单号：<text class="order_sn-text">{{ orderInfo['order_sn'] }}</text> <img id="copyImg" src="../img/common/copy1.png" /></<span>
    				<span>
    					下单时间：{{ orderInfo['addtime'] }}&nbsp;&nbsp;&nbsp;&nbsp;
    					支付时间：{{ orderInfo['paytime'] }}&nbsp;&nbsp;&nbsp;&nbsp;
    					支付方式：{{ orderInfo['type'] }}
    				</<span>
    			</div>
    		</div>
    		
	        <table class="table table-border table-bordered table-bg" style="margin:10px 20px 0 20px;width:calc(100% - 40px);">
	            <thead>
	                <tr class="text-c">
	                    <th width="60">商品图片</th>
	                    <th width="100">商品名称</th>
	                    <th width="40">产品价格</th>
	                    <th width="40">数量</th>
	                    <th width="40">总价</th>
	                    <th width="60">产品属性</th>
	                </tr>
	            </thead>
	
	            {% for list in prolist %}
	            <tr id="concent_tr_{{ list['id'] }}" class="text-c">
	                <td><img src="../files/uploadFiles/{{ list['photo_x'] }}" style="width:50px;height:50px"></td>
	                <td>{{ list['name'] }}</td>
	                <td>￥ {{ list['price'] }}</td>
	                <td>{{ list['num'] }}</td>
	                <td><font style="color:#c00;">￥ {{ list['price']*list['num'] }}</font>
	                </td>
	                <td>{{ list['attrs'] }}</td>
	            </tr>
	            {% endfor %}
	        </table>
    		
    		<!-- 收货地址 -->
    		<div class="shdz-div">
    			<text class="shdzd-title">收货地址：</text>{{ orderInfo['address'] }}&nbsp;{{ orderInfo['address_xq'] }}
    		</div>
    		<div class="order-other">
    			<div class="other-left"">
    				<span>买家留言</span>
    				<p>无</p>
    			</div>
    			<div class="other-left other-right">
    				<span>商家备注 
    					{% if orderInfo['note_grade']==1 %}<img id="ngImg" src="../img/common/note/note_red.png" title='等级一' />
						{% elseif orderInfo['note_grade']==2 %}<img id="ngImg" src="../img/common/note/note_yellow.png" title='等级二' />
						{% elseif orderInfo['note_grade']==3 %}<img id="ngImg" src="../img/common/note/note_green.png" title='等级三' />
						{% elseif orderInfo['note_grade']==4 %}<img id="ngImg" src="../img/common/note/note_blue.png" title='等级四' />
						{% elseif orderInfo['note_grade']==5 %}<img id="ngImg" src="../img/common/note/note_purple.png" title='等级五' />
						{% else %}<img src="../img/common/note/note_gray.png" title='无等级' />{% endif %}
    				</span>
					<a id="addNote" style="float:right;color:#3399ff;">修改备注</a>
					<p class="note-text">{{orderInfo['note']}}</p>
				</div>
    		</div>
    		<div class="order-other" style="border:none;">
    			<span>发票信息</span>
    			<p>{% if orderInfo['remark'] %} {{ orderInfo['remark'] }} {% else %} 无 {% endif %}</p>
    		</div>
    	</div>
    	
    	<h3 data-v-814df97a="" class="out-title-first">2.确认发货信息</h3>
    	<div class="confirm-addr">
    		<span class="fhaddress-show">{% if samr %}
    			{{ samr['fhname'] }}, {{ samr['tel'] }}, {{ samr['aname'] }}&nbsp;{{ samr['address'] }}
    			{% else %}暂无{% endif %}</span>
    		<div class="fr ivu-poptip">
    			<div class="ivu-poptip-rel" style="float:right;position:relative;">
    				<a class="re-fhdz-a">修改发货地址</a>
    				<div class="choose-address-div">
	    				<div class="triangle_border_up"></div>
	    				<div class="cad-div">
	    					<div class="cadd-top">
	    						<text>发货地址选着</text>
	    						<a class="address-managen" onclick='window.parent.creatIframe("../AMyDelivery/shipAddressPage", "发货地址")'>地址管理</a>
	    					</div>
	    					<div class="layui-form cadd-content"></div>
	    				</div>
    				</div>
				</div>
			</div>
    	</div>

		<h3 data-v-814df97a="" class="out-title-first">3.配置物流服务</h3>
		<div class="server">
			<p class="server-title">
				<span data-v-814df97a="" style="margin: 0px;">配送方式：普通快递</span>
				<span data-v-814df97a="">配送时间：只工作日送货(双休日、假日不用送)</span>
			</p>
			
			<form class="layui-form">
				<div class="layui-form-item set-express">
			  		<label class="layui-form-label">物流公司</label>
			    	<div class="layui-input-inline">
			      		<select name="city" style="width:100px">
							<option value="0">请选择</option>
							{% for lc in lcarr %}
							<option value="{{lc['id']}}" {% if lc['default']=='D1' %}selected="selected"{% endif %}>{{lc['name']}}</option>
							{% endfor %}
						</select>
			    	</div>
			    	<label class="layui-form-label">物流单号</label>
			    	<div class="layui-input-inline">
			    		<input type="text" name="title" required  lay-verify="required" placeholder="物流单号" autocomplete="off" class="layui-input">
			    	</div>
			  	</div>
			</form>
		</div>
		
		<p class="btn-box">
			<button type="button" class="btn-so ivu-btn ivu-btn-primary">
				<span>出库</span>
			</button>
			<button type="button" class="btn-so ivu-btn ivu-btn-ghost">
				<span>返回</span>
			</button>
		</p>
    </div>
    <script>
    	data = {
    			'id': {{ orderInfo['id'] }},
    			'note_grade': '{{ orderInfo['note_grade'] }}',
    			'note': '{{ orderInfo['note'] }}'
    	};
    	saarr = JSON.parse('{{saarr}}');

    	layui.use(['form'], function(){
    		form = layui.form;
    		
    		form.on('radio(fhaddress)', function(data){
    			cfhaddress = data.value;
    			$('.fhaddress-show').html(data.elem.title);
    			form.render();
    		}); 
    	});
    </script>

</body>

</html>