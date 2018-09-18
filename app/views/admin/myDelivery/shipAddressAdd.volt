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
    
    <title>发货地址</title>
</head>
<body style="min-height:auto">
<div class="page-container">
    
    <form id="saveSa" class="layui-form">
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 所在地区：</label>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="sheng" name="sheng" lay-verify="required" lay-skin="select" lay-filter="sheng">
					<option value="0">请选择省</option>
					{% for p in sheng %}
						<option value="{{p['id']}}" {% if p['checked']==true %}selected="selected"{% endif %}>{{p['area_name']}}</option>
					{% endfor %}
				</select>
			</div>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="shi" name="shi" lay-verify="required" lay-skin="select" lay-filter="shi" {% if id==0 %}disabled=""{% endif %}>
					<option value="0">请选择市/县</option>
					{% for p in shi %}
						<option value="{{p['id']}}" {% if p['checked']==true %}selected="selected"{% endif %}>{{p['area_name']}}</option>
					{% endfor %}
				</select>
			</div>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="qu" name="qu" lay-verify="required" lay-skin="select" lay-filter="qu" {% if id==0 %}disabled=""{% endif %}>
					<option value="0">请选择镇区</option>
					{% for p in qu %}
						<option value="{{p['id']}}" {% if p['checked']==true %}selected="selected"{% endif %}>{{p['area_name']}}</option>
					{% endfor %}
				</select>
			</div>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="jd" name="jd" lay-verify="required" lay-skin="select" lay-filter="jd" {% if id==0 %}disabled=""{% endif %}>
					<option value="0">请选择街道</option>
					{% for p in jd %}
						<option value="{{p['id']}}" {% if p['checked']==true %}selected="selected"{% endif %}>{{p['area_name']}}</option>
					{% endfor %}
				</select>
			</div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 详细地址：</label>
	        <div class="layui-input-inline">
	            <input type="text" name="address" required lay-verify="required" placeholder="详细地址"
	            autocomplete="off" class="layui-input" value="{{addressInfo['address']}}">
	        </div>
	        <label></label>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">邮编：</label>
	        <div class="layui-input-inline">
	            <input type="number" name="postcode" placeholder="邮编"
	            autocomplete="off" class="layui-input" value="{{addressInfo['postcode']}}">
	        </div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 联系电话：</label>
	        <div class="layui-input-inline">
	            <input type="number" name="tel" required lay-verify="required" placeholder="联系电话"
	            autocomplete="off" class="layui-input" value="{{addressInfo['tel']}}">
	        </div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 发货人姓名：</label>
	        <div class="layui-input-inline">
	            <input type="text" name="fhname" required lay-verify="required" placeholder="发货人姓名"
	            autocomplete="off" class="layui-input" value="{{addressInfo['fhname']}}">
	        </div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 设为默认：</label>
	        <div class="layui-input-inline">
	            <input type="checkbox" name="default" lay-skin="primary"
					{% if addressInfo['default']=='D1' %}checked="checked" {% endif %}>
	        </div>
	    </div>
	    
	    <div class="layui-form-item">
	        <div class="layui-input-block">
	        	 <input type="hidden" name="id" value="{{id}}">
	            <button class="layui-btn" lay-submit lay-filter="formSub">立即提交</button>
	            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
	        </div>
	    </div>
	</form>
</div>

</body>
</html>