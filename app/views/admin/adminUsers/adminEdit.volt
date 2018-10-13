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
        <article class="page-container">
			<form id="aeForm" class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
					<div class="formControls col-xs-8 col-sm-9"> 
						<input id="name" name="name" type="text" class="input-text" value="{{adminInfo['name']}}" placeholder="名称" {% if adminInfo['id'] %} disabled="disabled" disabled="disabled" {% endif %} />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="uname" name="uname" type="text" class="input-text" value="{{adminInfo['uname']}}" placeholder="名称" />
					</div>
				</div>
				{% if !adminInfo['id'] %}
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="pwd" name="pwd" type="password" class="input-text" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="qpwd" name="qpwd" type="password" class="input-text" />
					</div>
				</div>
				{% endif %}
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="phone" name="phone" type="text" class="input-text" value="{{adminInfo['phone']}}" placeholder="手机号" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="email" name="email" type="text" class="input-text" value="{{adminInfo['email']}}" placeholder="邮箱" />
					</div>
				</div>
				{% if mtype!='T1' %}
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>职位：</label>
					<div class="formControls col-xs-8 col-sm-9">
						{% for list in roleArr %}
						<label class="role-label">
							<input type="checkbox" class="role-item" {% if list['checked']==1 %}checked="checked"{% endif %} value="{{list['id']}}">
							{{list['name']}}
						</label>
						{% endfor %}
					</div>
				</div>
				{% endif %}
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" onClick="editAdmin();" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
						<input id="id" name="id" type="hidden" value="{{adminInfo['id']}}" />
						<input id="mtype" type="hidden" value="{{mtype}}" />
					</div>
				</div>
			</form>
		</article>
	</body>
</html>