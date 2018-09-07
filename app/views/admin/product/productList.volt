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
        <title>产品列表</title>

        <style>
        	.layui-table-cell{ height:auto; }
        </style>
    </head>

    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
        		<i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>产品管理
	            <span class="c-gray en">&gt;</span>全部产品
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
        	</div>
        </nav>
        <div class="page-container">
			<div class="toolbar">
			  	<a class="btna" onclick="openEdit('添加商品','../Amaterial/goodsEditPage','800','500')">
			    	<i class="layui-icon">&#xe654;</i>添加
			 	</a>
			  	<a class="btna" onclick="openEdit('批量导入','../Product/peiPage','600','300')">
			    	<i class="layui-icon">&#xe645;</i>导入
			 	</a>
			</div>
		    <table id="pro-table" class="layui-table" lay-data="{id:'pros', height:'full-120', loading:true, page:true, limit:30, url:'../Product/proList'}" lay-filter='pros'>
				<thead>
					<tr>
						<th lay-data="{field:'id', width:60, sort:true, align:'center'}">ID</th>
					 	<th lay-data="{field:'photo_x', width:150, sort:true, align:'center'}">图片</th>
					 	<th lay-data="{field:'brand_id', width:70, align:'center'}">品牌</th>
						<th lay-data="{field:'name', width:400, sort:true, align:'center'}">产品名称</th>
						<th lay-data="{field:'price_yh', width:100, sort:true,}">价格/元</th>
					   	<th lay-data="{field:'renqi', width:80, sort:true}">人气</th>
					 	<th lay-data="{field:'attrs', width:130, align:'center'}">属性(点击修改)</th>
					 	<th lay-data="{field:'stype', width:80, sort: true, align:'center', fixed:'right'}">推荐</th>
					  	<th lay-data="{field:'operate', width:160, sort: true, fixed:'right', style:'height:91px'}">操作</th>
					</tr>
				</thead>
			</table>
            <!-- <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr>
                        <th scope="col" colspan="9">产品列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="100">图片</th>
			            <th width="80">所属品牌</th>
			            <th width="180">产品名称</th>
			            <th width="40">价格/元</th>
			            <th width="40">人气</th>
			            <th width="40">属性(点击修改)</th>
			            <th width="20">推荐</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	{% for list in products %}
                    <tr class="text-c">
                        <td>{{ list['id'] }}</td>
		                <td style="padding:3px 0;"><img src="../files/uploadFiles/{{ list['photo_x'] }}" width="80px" height="80px"/></td>
		                <td>{{ list['brand_id'] }}</td>
		                <td>{{ list['name'] }}</td>
		                <td>{{ list['price_yh'] }}</td>
		                <td>{{ list['renqi'] }}</td>
		                <td>
		                	<p id="new_{{ list['id'] }}">{% if list['is_show']==1 %}<a class="label blue" onclick="pro_new({{ list['id'] }},1)">新品上市{% else %}<a class="label err" onclick="pro_new({{ list['id'] }},0);">非新品{% endif %}</a></p>
		                    <p id="hot_{{ list['id'] }}" style="margin-top:5px;">{% if list['is_hot']==1 %}<a class="label succ" onclick="pro_hot({{ list['id'] }},1)">热卖商品{% else %}<a class="label err" onclick="pro_hot({{ list['id'] }},0);">非热卖{% endif %}</a></p>
		                    <p id="zk_{$v.id}" style="margin-top:5px;"><if condition="$v.is_sale eq 1"><a class="label fail" onclick="pro_zk({$v.id},1);">折扣商品<else /><a class="label err" onclick="pro_zk({$v.id},0);">非折扣</if></a></p>
		                </td>
		                <td class="td-status">{% if list['stype']==1 %}<label style="color:green;">推荐</label>{% endif %}</td>
                        <td class="td-manage">
                        	{% if list['stype'] != 1 %}
                        	<a style="text-decoration:none" onclick="admin_start(this,{{ list['id'] }})" href="javascript:;" title="推荐">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            {% else %}
                            <a style="text-decoration:none" onClick="admin_stop(this,{{ list['id'] }})" href="javascript:;" title="取消推荐">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            {% endif %}
                            <a title="编辑" href="../Product/paPage?pid={{ list['id'] }}" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="admin_del(this,{{ list['id'] }})" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table> -->
        </div>
        <script>


        </script>
    </body>
</html>