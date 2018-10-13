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
    	<nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>权限管理
	            <span class="c-gray en">&gt;</span>入驻店铺权限管理
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <article class="page-container" style="margin-top:10px;">
			<form class="form form-horizontal">
				<div class="row cl">
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
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" onClick="editShopRight();" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
					</div>
				</div>
			</form>
		</article>
	</body>
</html>