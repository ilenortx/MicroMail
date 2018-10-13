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
	            <span class="c-gray en">&gt;</span>系统配置
	            <span class="c-gray en">&gt;</span>模块维护
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="layui-tab layui-tab-brief">
		  	<ul class="layui-tab-title">
			    <li class="layui-this">功能管理</li>
			    <li>操作码</li>
			</ul>
			<div class="layui-tab-content">
			    <div class="layui-tab-item layui-show">
			    	<div class="toolbar">
			    		<a class="btna" onclick="openEdit('添加功能','../Asysdeploy/apEditPage','800','500')">
			    			<i class="layui-icon">&#xe654;</i>添加
			    		</a>
			    	</div>
			    	
			    	<table id="apps-table" class="layui-hide" lay-filter='apps'></table>
			    	<!-- <table id="apps-table" class="layui-table" lay-data="{id:'apps', height:'full-165', loading:true, page:true, limit:30, url:'../Asysdeploy/allApps'}" lay-filter='apps'>
						<thead>
					    	<tr>
					      		<th lay-data="{field:'id', width:60, sort:true, align:'center'}">ID</th>
					      		<th lay-data="{field:'name', width:150, sort:true}">名称</th>
					      		<th lay-data="{field:'ename', width:150, sort:true}">英文名</th>
					      		<th lay-data="{field:'pid', width:80, align:'center'}">上级ID</th>
					      		<th lay-data="{field:'path', width:100}">链接地址</th>
					      		<th lay-data="{field:'icon', width:60}">图标</th>
					      		<th lay-data="{field:'remark'}">说明</th>
					      		<th lay-data="{field:'status', width:80, sort:true}">状态</th>
					      		<th lay-data="{width:160, toolbar:'#bar-apps'}">操作</th>
					    	</tr>
					  	</thead>
					</table> -->
					<script type="text/html" id="bar-apps">
  						<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 编辑</a>
  						<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</a>
					</script>
			    </div>
			    <div class="layui-tab-item">
			    	<div class="toolbar">
			    		<a class="btna" onclick="openEdit('添加操作码','../Asysdeploy/opcodeEditPage','500','300')">
			    			<i class="layui-icon">&#xe654;</i>添加
			    		</a>
			    	</div>
			    	
			    	<table id="opcode-table" class="layui-table" lay-filter='opcode'></table>
			    	<!-- <table id="opcode-table" class="layui-table" lay-data="{id:'opcode', height:'500px', width:'777', loading:true, page:true, limit:30, url:'../Asysdeploy/allOpcode'}" lay-filter='opcode'>
						<thead>
					    	<tr>
					      		<th lay-data="{field:'id', width:60, sort:true, align:'center'}">ID</th>
					      		<th lay-data="{field:'name', width:150, sort:true}">名称</th>
					      		<th lay-data="{field:'code', width:150, sort:true, align:'right'}">操作码</th>
					      		<th lay-data="{field:'status', width:150, sort:true, align:'center'}">状态</th>
					      		<th lay-data="{field:'sort', width:100, sort:true}">排序</th>
					      		<th lay-data="{width:160, toolbar:'#bar-opcode'}">操作</th>
					    	</tr>
					  	</thead>
					</table> -->
					<script type="text/html" id="bar-opcode">
  						<a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 编辑</a>
  						<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</a>
					</script>
			    </div>
			</div>
		</div> 
        
	</body>
</html>