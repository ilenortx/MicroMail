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
	            <span class="c-gray en">&gt;</span>职位管理
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="layui-tab layui-tab-brief">
			<div class="layui-tab-content">
			    <div class="toolbar">
			    	<a class="btna" onclick="openEdit('添加职位','../Adminusers/roleEditPage','800','500')">
			    		<i class="layui-icon">&#xe654;</i>添加
			    	</a>
			    </div>
			    	
			    <table id="role-table" class="layui-table" lay-data="{id:'roles', height:'full-130', loading:true, page:true, limit:30, url:'../Adminusers/shopRoles'}" lay-filter='roles'>
					<thead>
					    <tr>
					      	<th lay-data="{field:'id', width:60, sort:true, align:'center'}">ID</th>
					      	<th lay-data="{field:'name', width:150, sort:true, align:'center'}">名称</th>
					      	<th lay-data="{field:'remark'}">备注</th>
					      	<th lay-data="{field:'addtime', width:200, sort:true, align:'center'}">添加时间</th>
					      	<th lay-data="{field:'status', width:80, sort:true, align:'center'}">状态</th>
					      	<th lay-data="{width:160, toolbar:'#bar-roles'}">操作</th>
					    </tr>
					  </thead>
				</table>
				<script type="text/html" id="bar-roles">
  					<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 编辑</a>
  					<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</a>
				</script>
			</div>
		</div> 
	</body>
</html>