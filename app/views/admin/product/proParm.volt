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
            <script type="text/html" id="proTableToolbar">
                <div class="toolbar">
                    <a class="btna" href="../ProductParm/proParmAddPage">
                        <i class="layui-icon">&#xe654;</i>添加类型
                    </a>
                    <!-- <a class="btna" onclick="proDel()">
                        <i class="Hui-iconfont">&#xe609;</i>删除
                    </a> -->
                </div>
            </script>
            <table id="userListDataTables" class="table table-border table-bg table-hover table-sort">
            </table>
        </div>
        <script>
            function admin_del(e, id){
                layer.confirm('确认要删除吗？',function(index) {
                    $.ajax({
                        url: '../ProductParm/proParmDel',
                        type: 'POST',
                        dataType: 'json',
                        data: {ids: [id]},
                        success: function(data){
                            if (data.status == 1){
                                layer.msg('删除成功!', { icon: 6,time: 2000 }, function(){
                                    window.location.reload();
                                });
                            }else layer.msg(data.msg, { icon: 5, time: 1000 });
                        },
                        error: function(){

                        },
                    });
                });

            }
        </script>
    </body>
</html>