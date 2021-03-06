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
    
	{{ assets.outputCss('css1') }}
	<link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
	{{ assets.outputCss('css2') }}
        
    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>新增广告</title>
</head>
<body style="min-height:auto">
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 广告管理 <span class="c-gray en">&gt;</span> 公告设置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    <form class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>背景颜色：</label>
            <div class="formControls col-xs-8 col-sm-3">
            	<input type="color" name="bgcolor" id="bgcolor" value="{{ncInfo['bgcolor']}}" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>字体颜色：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="color" name="color" id="color" value="{{ncInfo['color']}}" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>滚动方向：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" name="direction" id="direction">
                    <option value="1" id="" {% if ncInfo['direction']==1 %}selected="selected"{% endif %}>向左</option>
                    <option value="2" id="" {% if ncInfo['direction']==1 %}selected="selected"{% endif %}>向右</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>滚动速度：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" name="speed" id="speed">
                    <option value="1" id="" name="gdfx" {% if ncInfo['speed']==1 %}selected="selected"{% endif %}>慢速</option>
                    <option value="2" id="" name="gdfx" {% if ncInfo['speed']==2 %}selected="selected"{% endif %}>常速</option>
                    <option value="3" id="" name="gdfx" {% if ncInfo['speed']==3 %}selected="selected"{% endif %}>快速</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="button" id="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</div>
<!--_footer 作为公共模版分离出去-->
{{ assets.outputJs('js1') }}
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
{{ assets.outputJs('js2') }}

<script>
    $('#submit').click(function(){
    	var bgcolor = $('#bgcolor').val();
    	var color = $('#color').val();
    	var direction = $('#direction').val();
    	var speed = $('#speed').val();
    	
    	if (bgcolor && color && direction && speed){
    		$.post('../Guanggao/noticeSet',{bgcolor:bgcolor, color:color, direction:direction, speed:speed},function(data){
    			var datas = jQuery.parseJSON(data);
            	if (datas.status == 1){
                    layer.msg('操作成功!', { icon: 6, time: 1000 });
            	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
    		});
    	}
    });
</script>


</body>
</html>