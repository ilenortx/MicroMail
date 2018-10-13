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
        <article class="page-container" style="margin-top:10px;">
			<form class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="name" name="name" type="text" class="input-text" value="{{roleInfo['name']}}" placeholder="名称" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>备注：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input id="remark" name="remark" type="text" class="input-text" value="{{roleInfo['remark']}}" placeholder="备注" />
					</div>
				</div>
				
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>职位权限：</label>
					<div class="formControls col-xs-8 col-sm-9">
						{% for list in rarr %}
						<dl class="permission-list">
							<dt>
								<label>
									<input type="checkbox" id="pa{{list['pappInfo']['id']}}">
									{{list['pappInfo']['name']}}
								</label>
							</dt>
							<dd>
								{% for l1 in list['app'] %}
								<dl class="cl permission-list2">
									<dt>
										<label class="">
											<input type="checkbox" id="a{{l1['appInfo']['id']}}">
											{{l1['appInfo']['name']}}
										</label>
									</dt>
									<dd>
										{% for l2 in l1['opcode'] %}
										<label class="">
											<input type="checkbox" class="opcode-item" {% if l2['checked']=='1' %}checked="checked"{% endif %} value="{{list['pappInfo']['id']}}-{{l1['appInfo']['id']}}-{{l2['id']}}" id="{{list['pappInfo']['id']}}-{{l1['appInfo']['id']}}-{{l2['id']}}">
											{{l2['name']}}
										</label>
										{% endfor %}
									</dd>
								</dl>
								{% endfor %}
							</dd>
						</dl>
						{% endfor %}
					</div>
				</div>
				
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" onClick="editRole();" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
						<input id="id" name="id" type="hidden" value="{{roleInfo['id']}}" />
					</div>
				</div>
			</form>
		</article>
	</body>
</html>