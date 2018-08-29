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
        
        {{ assets.outputCss('css1') }}
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        {{ assets.outputCss('css2') }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>店铺管理</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>店铺管理
	            <span class="c-gray en">&gt;</span>全部审核店铺
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
            <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="80">负责人</th>
			            <th width="80">店铺名称</th>
			            <th width="20">联系电话</th>
			            <th width="40">提交次数</th>
			            <th width="40">申请时间</th>
			            <th width="20">状态</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	{% for list in jsList %}
                    <tr class="text-c">
                        <td>{{ list['id'] }}</td>
		                <td>{{ list['uname'] }}</td>
		                <td>{{ list['shop_name'] }}</td>
		                <td>{{ list['utel'] }}</td>
		                <td>{{ list['shnum'] }}</td>
		                <td>{{ list['addtime'] }}</td>
		                <td class="td-status">
		                	{% if list['status']=='S0' %}
		                		待审核
		                	{% elseif list['status']=='S1' %}
		                		<label style="color:green;">审核中</label>
		                	{% elseif list['status']=='S3' %}
		                		<label style="color:red;">审核未通过</label>
		                	{% endif %}
		                </td>
                        <td class="td-manage">
                            <a title="审核" href="javascript:;" onclick="shop_audit('审核','../ShopManagement/shopAuditPage?id={{ list['id'] }}','5','','610')" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe695;</i>
                            </a>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
        <!--_footer 作为公共模版分离出去-->
        {{ assets.outputJs('js1') }}
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        {{ assets.outputJs('js2') }}
        <script>
	        $('#userListDataTables').DataTable({
	            bSort: true,      /*是否排序*/
	            bPaginate: true,  /*是否分页*/
	            bFilter: true,    /*是否查询*/
	            bInfo: true,      /*是否显示基本信息*/ 
	        });
	        
            /*编辑*/
            function shop_audit(title, url, id, w, h) {
                layer_show(title, url, w, h);
            }
            
        </script>
    </body>
</html>