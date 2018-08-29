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
        
        {{ assets.outputCss('css1') }}
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        {{ assets.outputCss('css2') }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>产品列表</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
	        	<i class="Hui-iconfont">&#xe67f;</i> 首页 
	        	<span class="c-gray en">&gt;</span> 品牌管理
	        	 <span class="c-gray en">&gt;</span>{% if bid %}<a href="../Brand/index">全部品牌</a> 
	        	 <span class="c-gray en">&gt;</span>品牌编辑 {% else %} 新增品牌 {% endif %}
	        	 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
	        	 	<i class="Hui-iconfont">&#xe68f;</i>
	        	 </a>
	        </div>
        </nav>
        <div class="page-container">
            <form class="form form-horizontal" action="../Brand/saveBrand" method="post" enctype="multipart/form-data">
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>品牌名称：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" placeholder="品牌名称" name="name" id="name" value="{{ brandInfo['name'] }}">
		            </div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>品牌图片，图片大小120*120</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input  type="file" name="file" id="file" value="">
		            </div>
		        </div>
		
		
		        <div class="row cl">
		            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
		                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		                {% if brandInfo['id'] %}<input type="hidden" name="bid" id="id" value="{{ brandInfo['id'] }}">{% endif %}
		            </div>
		        </div>
		    </form>
        </div>
        <!--_footer 作为公共模版分离出去-->
        {{ assets.outputJs('js1') }}
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        {{ assets.outputJs('js2') }}
    </body>
</html>