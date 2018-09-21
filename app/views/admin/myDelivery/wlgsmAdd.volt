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
					<option value="1" {% if wli['cys']=='1' %}selected="selected"{% endif %}>快递承运商</option>
				</select>
			</div>
			<label class="layui-form-label">* 物流公司：</label>
	        <div class="layui-input-inline" style="width:180px;">
				<input type="text" name="name" placeholder="物流公司"
	            autocomplete="off" class="layui-input" value="{{wli['name']}}">
			</div>
	    </div>
	    <div class="layui-form-item">
			<label class="layui-form-label">* 编码：</label>
	        <div class="layui-input-inline" style="width:180px;">
				<input type="text" name="code" placeholder="编码(英文大写)"
	            autocomplete="off" class="layui-input" value="{{wli['code']}}">
			</div>
	    </div>
	    <div class="layui-form-item">
			<label class="layui-form-label">电话：</label>
	        <div class="layui-input-inline" style="width:180px;">
				<input type="tel" name="tel" placeholder="电话"
	            autocomplete="off" class="layui-input" value="{{wli['tel']}}">
			</div>
	    </div>
	    <div class="layui-form-item">
			<label class="layui-form-label">* 即时查询：</label>
	        <div class="layui-input-inline" style="width:30px;">
				<input type="checkbox" name="isjscx" lay-skin="primary" {% if wli['isjscx']=='1' %}checked="checked"{% endif %}>
			</div>
			<label class="layui-form-label">* 物流跟踪：</label>
	        <div class="layui-input-inline" style="width:30px;">
				<input type="checkbox" name="iswlgz" lay-skin="primary" {% if wli['iswlgz']=='1' %}checked="checked"{% endif %}>
			</div>
			<label class="layui-form-label">* 电子面单：</label>
	        <div class="layui-input-inline" style="width:30px;">
				<input type="checkbox" name="isdzmd" lay-skin="primary" {% if wli['isdzmd']=='1' %}checked="checked"{% endif %}>
			</div>
			<label class="layui-form-label">* 取件：</label>
	        <div class="layui-input-inline" style="width:30px;">
				<input type="checkbox" name="isqj" lay-skin="primary" {% if wli['isqj']=='1' %}checked="checked"{% endif %}>
			</div>
	    </div>
	    <div class="layui-form-item">
			<label class="layui-form-label">* 是否需要账号：</label>
	        <div class="layui-input-inline" style="width:30px;">
				<input type="checkbox" name="isaccount" lay-skin="primary" {% if wli['isaccount']=='1' %}checked="checked"{% endif %}>
			</div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">备注说明：</label>
	        <div class="layui-input-inline" style="width:350px;">
	            <textarea name="remark" placeholder="请输入内容" class="layui-textarea">{{wli['remark']}}</textarea>
	        </div>
	    </div>
	    <div class="layui-form-item">
	        <label class="layui-form-label">排序：</label>
	        <div class="layui-input-inline">
	            <input type="number" name="sort" placeholder="排序"
	            autocomplete="off" class="layui-input" value="{{wli['sort']}}">
	        </div>
	        <label></label>
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