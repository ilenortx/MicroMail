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
        <title>分类列表</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>分类管理
	            <span class="c-gray en">&gt;</span>分类列表
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
	        <div class="text-c">
				备注：产品分类建议5个字以内，否则不能显示完整
			</div>
			<br>
            <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover">
                <thead>
                    <tr>
                        <th scope="col" colspan="4">分类列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="20">ID</th>
                        <th width="150">分类名称</th>
                        <th width="60">属性</th>
                        <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	{% for list1 in categoryLists %}
                    <tr class="text-c">
                        <td>{{ list1['id'] }}</td>
                        <td style="text-align:left">-{{ list1['name'] }}</td>
                        <td class="td-status">
                        	{% if list1['bz_2'] == '1' %}
                            <font style="color:#090">推荐</font>
                            {% endif %}
                        </td>
                        <td class="td-manage">
                        	{% if list1['bz_2'] != '1' %}
                        	<a style="text-decoration:none" onclick="admin_start(this,{{ list1['id'] }})" href="javascript:;" title="推荐">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            {% else %}
                            <a style="text-decoration:none" onClick="admin_stop(this,{{ list1['id'] }})" href="javascript:;" title="取消推荐">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            {% endif %}
                        </td>
                    </tr>
                    {% for list2 in list1['list2'] %}
                    <tr class="text-c">
                        <td>{{ list2['id'] }}</td>
                        <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;-{{ list2['name'] }}</td>
                        <td class="td-status">
                        	{% if list2['bz_2'] == '1' %}
                            <font style="color:#090">推荐</font>
                            {% endif %}
                        </td>
                        <td class="td-manage">
                        	{% if list2['bz_2'] != '1' %}
                        	<a style="text-decoration:none" onclick="admin_start(this,{{ list2['id'] }})" href="javascript:;" title="推荐">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            {% else %}
                            <a style="text-decoration:none" onClick="admin_stop(this,{{ list2['id'] }})" href="javascript:;" title="取消推荐">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            {% endif %}
                            <a title="编辑" href="../Category/cgAPage?cgid={{ list2['id'] }}&edit=true" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,{{ list2['id'] }})" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
                        </td>
                    </tr>
                    {% for list3 in list2['list3'] %}
                    <tr class="text-c">
                        <td>{{ list3['id'] }}</td>
                        <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-{{ list3['name'] }}</td>
                        <td class="td-status">
                        	{% if list3['bz_2'] == '1' %}
                            <font style="color:#090">推荐</font>
                            {% endif %}
                        </td>
                        <td class="td-manage">
                        	{% if list3['bz_2'] != '1' %}
                        	<a style="text-decoration:none" onclick="admin_start(this,{{ list3['id'] }})" href="javascript:;" title="推荐">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            {% else %}
                            <a style="text-decoration:none" onClick="admin_stop(this,{{ list3['id'] }})" href="javascript:;" title="取消推荐">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            {% endif %}
                            <a title="编辑" href="../Category/cgAPage?cgid={{ list3['id'] }}&edit=true" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,{{ list3['id'] }})" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
                        </td>
                    </tr>
                    {% endfor %}
                    {% endfor %}
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
	            bSort: false,      /*是否排序*/
	            bPaginate: false,  /*是否分页*/
	            bFilter: false,    /*是否查询*/
	            bInfo: false,      /*是否显示基本信息*/ 
	        });
            /*分类-删除*/
            function admin_del(obj, id) {
                layer.confirm('确认要删除吗？',
                function(index) {
                	$.post('../Category/deleteCategory', {'id':id}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").remove();
                            layer.msg('已删除!', { icon: 1,time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*分类-编辑*/
            function admin_edit(title, url, id, w, h) {
                layer_show(title, url, w, h);
            }
            /*分类-取消推荐*/
            function admin_stop(obj, id) {
                layer.confirm('确认要取消推荐吗？',
                function(index) {
                    $.post('../Category/setBz2', {'id':id, 'bz':'0'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="推荐" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('');
                            $(obj).remove();
                            layer.msg('已取消推荐!', { icon: 5, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*分类-推荐*/
            function admin_start(obj, id) {
                layer.confirm('确认要推荐吗？',
                function(index) {
                	$.post('../Category/setBz2', {'id':id, 'bz':'1'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="取消推荐" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<font style="color:#090">推荐</font>');
                            $(obj).remove();
                            layer.msg('已推荐!', { icon: 6, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 6, time: 1000 });
                    });
                });
            }
        </script>
    </body>
</html>