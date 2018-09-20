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
	            <span class="c-gray en">&gt;</span>产品属性
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
        	</div>
        </nav>
        <div class="page-container">
        	<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
					<a href="javascript:;" onclick="openEdit('添加属性','../ProductAttr/proAttrAddPage','800','650')" class="btn btn-primary radius">
						<i class="Hui-iconfont">&#xe600;</i>添加属性
					</a>
				</span>
			</div>
		    <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="100">名称</th>
			            <th width="60">类型</th>
			            <th width="200">属性值</th>
			            <th width="60">排序</th>
			            <th width="80">状态</th>
			            <th width="80">审核</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	{% for list in proAttrs %}
                    <tr class="text-c">
                        <td>{{ list['id'] }}</td>
		                <td>{{ list['name'] }}</td>
		                <td>{% if list['type']=='T1' %}所有商品{% else %}部分商品{% endif %}</td>
		                <td>{{list['values']}}</td>
		                <td>{{ list['sort'] }}</td>
		                <td class="td-status">{% if list['status']=='S1' %}<label style="color:green;">使用</label>{% else %}禁用{% endif %}</td>
		                <td class="td-status">
		                	{% if list['audit_result']=='R0' %}<label style="color:red;">待审核</label>
		                	{% elseif list['audit_result']=='R1' %}<label style="color:red;">审核中</label>
		                	{% elseif list['audit_result']=='R2' %}<label style="color:red;">审核中</label>
		                	{% elseif list['audit_result']=='R3' %}<label style="color:green;">通过</label>
		                	{% endif %}</td>
                        <td class="td-manage">
                            <a title="编辑" onclick="openEdit('修改属性','../ProductAttr/proAttrAddPage?id={{list['id']}}','800','650')" href="javascript:;" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,{{ list['id'] }})" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
        <script>
	        $('#userListDataTables').DataTable({
	            bSort: false,      /*是否排序*/
	            bPaginate: false,  /*是否分页*/
	            bFilter: false,    /*是否查询*/
	            bInfo: false,      /*是否显示基本信息*/ 
	        });
	        
	        function attrAdd(title, url, w, h){
	        	layer_show(title,url,w,h);
	        }
        </script>
    </body>
</html>