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
    

    <title>物流公司</title>
</head>
<body style="min-height:auto">
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 我的配送 <span class="c-gray en">&gt;</span>物流管理<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    
    <script type="text/html" id="logisticsTableToolbar">
		<div class="toolbar">
			<a class="btna" onclick="openEditFull('添加物流','../Amydelivery/wlgsmAddPage')">
			    <i class="layui-icon">&#xe654;</i>添加物流
			</a>
		</div>
	</script>
    <table id="logistics-table" class="layui-hide" lay-filter='logistics'></table>
    
    <script type="text/html" id="bar-opcode">
  		<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 编辑</a>
  		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</a>
	</script>
</div>

</body>
</html>