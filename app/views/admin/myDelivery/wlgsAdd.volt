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
    
    <title>添加物流公司</title>
</head>
<body style="min-height:auto">
<div class="page-container">
    
    <form id="saveLc" class="layui-form" style="padding-top:20px;">
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 承运商：</label>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="cys" name="cys" lay-verify="required" lay-skin="select" lay-filter="cys">
					<option value="0">请选择</option>
					{% for c in cys %}
						<option value="{{c['ccid']}}" {% if ccys==c['ccid'] %}selected="selected"{% endif %}>{{c['ccname']}}</option>
					{% endfor %}
				</select>
			</div>
			<label class="layui-form-label">* 物流公司：</label>
	        <div class="layui-input-inline" style="width:100px;">
				<select id="wlgs" name="wlgs" lay-verify="required" lay-skin="select" lay-filter="wlgs" {% if id==0 %}disabled="disabled"{% endif %}>
					<option value="0">请选择</option>
					{% for c in cwlgs %}
					<option value="{{c['code']}}" {% if c['code']==lcifno['code'] %}selected="selected"{% endif %}>{{c['name']}}</option>
					{% endfor %}
				</select>
			</div>
	    </div>
	    
	    <div class="layui-form-item">
	        <label class="layui-form-label">备注说明：</label>
	        <div class="layui-input-inline" style="width:350px;">
	            <textarea name="remark" placeholder="请输入内容" class="layui-textarea">{{lcifno['remark']}}</textarea>
	        </div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">排序：</label>
	        <div class="layui-input-inline">
	            <input type="number" name="sort" placeholder="排序"
	            autocomplete="off" class="layui-input" value="lcifno['sort']">
	        </div>
	        <label></label>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">* 设为默认：</label>
	        <div class="layui-input-inline">
	            <input type="checkbox" name="default" lay-skin="primary"
					{% if lcifno['default']=='D1' %}checked="checked" {% endif %}>
	        </div>
	    </div>
	    
	    <div class="layui-form-item">
	        <div class="layui-input-block">
	        	 <input type="hidden" name="id" value="{{id}}">
	            <button class="layui-btn" lay-submit lay-filter="formSub">保存</button>
	        </div>
	    </div>
	</form>
</div>
<script>
	wlgsarr = JSON.parse('{{wlgs}}');
</script>
</body>
</html>