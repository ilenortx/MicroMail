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
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
        		<i class="Hui-iconfont">&#xe67f;</i> 首页 
        		<span class="c-gray en">&gt;</span> 系统管理
        		<span class="c-gray en">&gt;</span> 任务回收站
        		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
        			<i class="Hui-iconfont">&#xe68f;</i>
        		</a>
        	</div>
        </nav>
        <div class="page-container">
			<script type="text/html" id="tqTableToolbar">
  				<div class="toolbar">
					<a class="btna" onclick="restore()"> <i class="layui-icon">&#xe666;</i>还原选中 </a>
			  	<a class="btna" onclick="delig()"> <i class="layui-icon">&#xe640;</i>删除选中 </a>
				</div>
			</script>
			<table id="tq-table" class="layui-hide" lay-filter='tqrb'></table>
		    <!-- <table id="tq-table" class="layui-table" lay-data="{id:'tqrb', height:'full-120', loading:true, page:true, limit:30, url:'../Asysmanage/tqrbList'}" lay-filter='tqrb'>
				<thead>
					<tr>
						<th lay-data="{type:'checkbox'}"></th>
						<th lay-data="{field:'id', width:60, align:'center', sort:true}">ID</th>
					 	<th lay-data="{field:'name', width:150, sort:true}">任务名</th>
					 	<th lay-data="{field:'admin', width:100,}">添加者</th>
					 	<th lay-data="{field:'tdesc', width:100, align:'center'}">类型</th>
						<th lay-data="{field:'intime', width:150, sort:true, align:'center'}">添加时间</th>
						<th lay-data="{field:'dotime', width:150, sort:true,}">执行时间</th>
					   	<th lay-data="{field:'etime', width:150, sort:true}">完成时间</th>
					 	<th lay-data="{field:'remark'}">备注</th>
					</tr>
				</thead>
			</table> -->
        </div>
        <script>
        	
        </script>
    </body>
</html>