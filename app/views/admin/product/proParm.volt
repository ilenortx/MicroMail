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

    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
        		<i class="Hui-iconfont">&#xe67f;</i>首页
                <span class="c-gray en">&gt;</span>产品管理
                <span class="c-gray en">&gt;</span>参数类型
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
        	</div>
        </nav>
        <div class="page-container">
        	<!-- <div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
					<a href="javascript:;" onclick="" class="btn btn-primary radius">
						<i class="Hui-iconfont">&#xe600;</i>添加属性
					</a>
				</span>
			</div> -->
            <table id="userListDataTables" class="table table-border table-bg table-hover table-sort">
            </table>
        </div>
        <script>
            $(document).ready(function(){
                layui.use('table', function(){
                    var table = layui.table;

                    table.render({
                        elem: '#userListDataTables',
                        url: '../ProductParm/getAllParm',
                        toolbar: false,
                        title: '用户数据表',
                        cols: [[
                            {field:'id', title:'ID', width:80, unresize: true, sort: true},
                            {field:'t_name', title:'类型名称', unresize: true,},
                            {field:'control', title:'操作', unresize: true,}
                        ]],
                        page: true,
                        parseData: function(res){
                            for (var i = 0; i < res.data.length; i++) {
                                res.data[i].control = '<a title="编辑" href="../ProductParm/proParmAddPage?id='+ res.data[i].id +'" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"></i></a><a title="删除" href="javascript:;" onclick="admin_del(this,'+ res.data[i].id +')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"></i></a>';
                            };

                            return {
                                "code": res.code,
                                "msg": res.msg,
                                "count": res.total,
                                "data": res.data,
                            };
                        }
                    });
                });
            });
        </script>
    </body>
</html>