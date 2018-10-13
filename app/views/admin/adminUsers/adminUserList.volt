<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="Bookmark" href="/favicon.ico">
        <link rel="Shortcut Icon" href="/favicon.ico" />
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
        <title>管理员列表</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>权限管理
	            <span class="c-gray en">&gt;</span>管理员列表
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
            <div class="toolbar">
				<a class="btna" onclick="openEdit('添加管理员','../Adminusers/adminEditPage','800','500')">
			 		<i class="layui-icon">&#xe654;</i>添加
				</a>
			</div>
			
			<table id="admin-table" class="layui-table" lay-data="{id:'admins', height:'full-130', loading:true, url:'../Adminusers/shopAdmin'}" lay-filter='admins'>
				<thead>
					<tr>
					  	<th lay-data="{field:'id', width:60, sort:true, align:'center'}">ID</th>
					  	<th lay-data="{field:'name', width:120, sort:true}">账号</th>
					 	<th lay-data="{field:'uname', width:120, sort:true}">名称</th>
					 	<th lay-data="{field:'phone', width:180, sort:true, align:'center'}">手机号</th>
						<th lay-data="{field:'email', width:180, sort:true, align:'center'}">邮箱</th>
						<th lay-data="{field:'addtime', width:180, sort:true, align:'center'}">添加时间</th>
					  	<th lay-data="{field:'statusdesc', width:80, sort:true, align:'center'}">状态</th>
						<th lay-data="{width:250, toolbar:'#bar-admin'}">操作</th>
					</tr>
				</thead>
			</table>
			<script type="text/html" id="bar-admin">
  				<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 编辑</a>
  				<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="cstatus"><i class="layui-icon">&#xe62c;</i> 状态</a>
  				<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</a>
			</script>
        </div>
        <script type="text/javascript">
	        
        </script>
    </body>
</html>