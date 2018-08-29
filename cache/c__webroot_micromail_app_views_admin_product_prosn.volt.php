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
        
        <?= $this->assets->outputCss() ?>
        <?= $this->assets->outputJs() ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>产品服务说明</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
        		<i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>产品管理
	            <span class="c-gray en">&gt;</span>服务说明
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
        	</div>
        </nav>
        <div class="page-container">
        	<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
					<a href="javascript:;" onclick="prosnAdd('添加服务说明','../Product/prosnAddPage','600','350')" class="btn btn-primary radius">
						<i class="Hui-iconfont">&#xe600;</i>添加促销
					</a>
				</span>
			</div>
            <table id="allSnTable" class="table table-border table-bordered table-bg table-hover table-sort">
		    	<thead>
		          	<tr class="text-c">
					  	<th width="100">标题</th>
					 	<th width="100">内容</th>
					 	<th width="20">操作</th>
		         	</tr>
		     	</thead>
		     	<tbody>
		                	
		      	</tbody>
		    </table>
        </div>
        <script>
	        var sntable = $('#allSnTable').DataTable({
	            bSort: false,      /*是否排序*/
	            bPaginate: false,  /*是否分页*/
	            bFilter: false,    /*是否查询*/
	            bInfo: false,      /*是否显示基本信息*/ 
	            ajax: {
	                url: "../Product/prosnList"
	            },
	            "columns": [
	                { "data": "title" },
	                { "data": "descript" },
	                { "data": "edit" }
	            ]
	        });

	        function prosnAdd(title, url, w, h){
	        	layer_show(title,url,w,h);
	        }

	        function reloadData(){
	        	sntable.ajax.reload(function (json) {  });
		    }
	        function prosnDel(obj, id){
	        	$.post('../Product/delProsn', {'id':id}, function(data){
                	var datas = jQuery.parseJSON(data);
                	if (datas.status == 1){
                		$(obj).parents("tr").remove();
                        layer.msg('已删除!', { icon: 1,time: 1000 });
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                });
	        }
        </script>
    </body>
</html>