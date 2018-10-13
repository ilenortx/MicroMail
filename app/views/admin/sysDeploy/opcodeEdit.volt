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
					<label class="col-xs-4 col-sm-3" style="text-align:right;"><span class="c-red">*</span>名称：</label>
					<div class="formControls col-xs-5 col-sm-9">
						<input id="name" name="name" type="text" class="input-text" value="{{opcodeInfo['name']}}" placeholder="名称" />
					</div>
				</div>
				<div class="row cl">
					<label class="col-xs-4 col-sm-3" style="text-align:right;"><span class="c-red">*</span>操作码：</label>
					<div class="formControls col-xs-5 col-sm-9">
						<input id="code" name="code" type="text" class="input-text" value="{{opcodeInfo['code']}}" placeholder="操作码" />
					</div>
				</div>
				<div class="row cl">
					<label class="col-xs-4 col-sm-3" style="text-align:right;"><span class="c-red">*</span>排序：</label>
					<div class="formControls col-xs-5 col-sm-9">
						<input id="sort" name="sort" type="number" class="input-text" value="{{opcodeInfo['sort']}}">
					</div>
				</div>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" onClick="editOpcode();" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
						<input id="id" name="id" type="hidden" value="{{opcodeInfo['id']}}" />
					</div>
				</div>
			</form>
		</article>
	</body>
</html>