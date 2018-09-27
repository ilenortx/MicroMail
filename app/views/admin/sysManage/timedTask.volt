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
        		<span class="c-gray en">&gt;</span> 定时任务
        		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
        			<i class="Hui-iconfont">&#xe68f;</i>
        		</a>
        	</div>
        </nav>
        <div class="page-container">
			<script type="text/html" id="tqTableToolbar">
  				<div class="toolbar">
					<a class="btna" onclick="del()"> <i class="layui-icon">&#xe640;</i>删除选中 </a>
				</div>
			</script>
			<table id="tt-table" class="layui-hide" lay-filter='timedTask'></table>
        </div>
        <script type="text/html" id="bar-opcode">
        	<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  			<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="excute">执行</a>
        </script>
        
        <!-- 编辑模板 -->
        <script type="text/html" id="eidtTemp">
        	<form class="form form-horizontal" action="#" method="post" style="border:1px solid #dedede;margin:20px;padding-bottom:20px;">
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3">定时任务ID:</label>
		            <div id="etid" class="col-xs-3 col-sm-3 inline"></div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3">定时器类型:</label>
		            <div id="ettype" class="col-xs-3 col-sm-3 inline"></div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3">最后执行时间:</label>
		            <div id="etletime" class="col-xs-3 col-sm-3 inline"></div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3">描述:</label>
		            <div id="etdescript" class="col-xs-3 col-sm-3 inline">撒旦发生</div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>规则:</label>
		            <div class="formControls col-xs-3 col-sm-3 inline">
		                <input id="etrule" name="rule" type="text" class="input-text" placeholder="规则">
		            </div>
		        </div>
		        <div class="row cl">
		            <label class="form-label col-xs-3 col-sm-3">是否启用:</label>
		            <div class="formControls col-xs-3 col-sm-3 select-box inline" style="margin:0 15px">
		                <select id="etstatus" name="status" class="select">
							<option value="S1">启用</option>
							<option value="S0">停用</option>
						</select>
		            </div>
		        </div>
		
		
		        <div class="row cl">
		            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
		                <input id="etsubmit" class="btn btn-primary radius" type="button" name="submit" value="&nbsp;&nbsp;提&nbsp;交&nbsp;&nbsp;">
		            </div>
		        </div>
		    </form>
        </script>
    </body>
</html>