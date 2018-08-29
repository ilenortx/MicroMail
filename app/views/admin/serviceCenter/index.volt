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
	            <span class="c-gray en">&gt;</span>疑难问题
	            <span class="c-gray en">&gt;</span>管理问题
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="../ServiceCenter/editPage" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加问题</a></span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
        	<table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="80">名称</th>
			            <th width="150">描述</th>
			            <th width="80">状态</th>
			            <th width="20">操作</th>
                    </tr>
                </thead>
                <tbody>
                	{% for list in scArr %}
                    <tr class="text-c">
                        <td>{{ list['id'] }}</td>
		                <td>{{ list['name'] }}</td>
		                <td>{{ list['content'] }}</td>
		                <td class="td-status">
		                	{% if list['status']== 'S1' %}
		                		<label style="color:green;">正常</label>
		                	{% else %}
		                		<label style="color:red;">停用</label>
		                	{% endif %}
		                </td>
                        <td class="td-manage">
                            <a title="编辑" href="../ServiceCenter/editPage?scid={{list['id']}}" class="ml-5" style="text-decoration:none">
								编辑
                            </a> | 
                        	{% if list['status'] != 'S1' %}
                            <a style="text-decoration:none" onClick="setStatus(this, {{list['id']}}, 'S1')" href="javascript:;" title="使用">
								使用
                            </a>
                            {% else %}
                        	<a style="text-decoration:none" onclick="setStatus(this, {{list['id']}}, 'S0')" href="javascript:;" title="停用">
                            	停用
                            </a>
                            {% endif %}
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
	            bPaginate: false,  /*是否分页*/
	            bFilter: false,    /*是否查询*/
	            bInfo: true,      /*是否显示基本信息*/ 
	        });
	        
            /*修改状态*/
            function setStatus(obj, id, status) {
            	$.post('../ServiceCenter/setStatus', {'id':id, 'status':status}, function(data){
                	var datas = jQuery.parseJSON(data);
                   	if (datas.status == 1){
                    	if (status == 'S0') {
                    		$(obj).parents("tr").find(".td-manage").append('<a onClick="setStatus(this, '+id+', \'S1\')" href="javascript:;" title="使用" style="text-decoration:none">使用</a>');
                    		$(obj).parents("tr").find(".td-status").html('<label style="color:red;">停用</label>');
                    	}
                    	else {
                    		$(obj).parents("tr").find(".td-manage").append('<a onClick="setStatus(this, '+id+', \'S0\')" href="javascript:;" title="停用" style="text-decoration:none">停用</a>');
                    		$(obj).parents("tr").find(".td-status").html('<label style="color:green;">正常</label>');
                    	}
                     	$(obj).remove();
                     	layer.msg('操作成功!', { icon: 6, time: 1000 });
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
             	});
            }
        </script>
    </body>
</html>