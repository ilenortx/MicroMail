<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!--[if lt IE 9]>
            <script type="text/javascript" src="lib/html5shiv.js"></script>
            <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->
        
        {{ assets.outputCss() }}
        {{ assets.outputJs() }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
	</head>
    
    <body>
        <article class="page-container" style="margin:0;">
			<form class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<input id="name" name="name" type="text" class="input-text" value="{{appInfo['name']}}" placeholder="名称" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>英文名：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<input id="ename" name="ename" type="text" class="input-text" value="{{appInfo['ename']}}" placeholder="英文名" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>路径：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<input id="path" name="path" type="text" class="input-text" value="{{appInfo['path']}}" placeholder="路径" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父级：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<select id="pid" name="pid" lay-filter="aihao">
						  	<option value="0">一级菜单</option>
						  	{% for list in sms %}
						  	{% if list['id']!=appInfo['id'] %}
						   	<option value="{{list['id']}}" {% if list['id']==appInfo['pid'] %}selected="selected"{% endif %}>{{list['name']}}</option>
						   	{% endif %}
						   	{% endfor %}
					 	</select>
					</div>
				</div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图标：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<input id="icon" name="icon" type="text" class="input-text" value="{{appInfo['icon']}}" placeholder="图标" />&nbsp;&nbsp;
						<i id="icon-pvw" class="Hui-iconfont">{{appInfo['icon']}}</i><!-- 图标预览 -->
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>备注：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<input id="remark" name="remark" type="text" class="input-text" value="{{appInfo['remark']}}">
					</div>
				</div>
				<div class="row cl" id="opcode-list-row">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>操作码：</label>
					<div class="formControls col-xs-8 col-sm-5">
						<?php foreach ($opcodes as $k=>$v) {?>
						<label class="opcode-label">
							<input type="checkbox" value="{{v['id']}}" class="opcode-list" <?php if (in_array($v['id'], $appInfo['oids'])) {?>checked="checked"<?php } ?>>&nbsp;{{v['name']}}
						</label>
						<?php } ?>
					</div>
				</div>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" onClick="editApp();" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
						<input id="id" name="id" type="hidden" value="{{appInfo['id']}}" />
					</div>
				</div>
			</form>
		</article>
	</body>
</html>