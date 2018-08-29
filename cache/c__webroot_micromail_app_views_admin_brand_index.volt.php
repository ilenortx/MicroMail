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
        
        <?= $this->assets->outputCss('css1') ?>
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        <?= $this->assets->outputCss('css2') ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>产品列表</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 品牌管理 <span class="c-gray en">&gt;</span> 全部品牌 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
        <div class="page-container">
            <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
			        <tr class="text-c">
			            <th width="40">ID</th>
			            <th width="150">logo图片</th>
			            <th width="130">品牌名称</th>
			            <th width="80">是否推荐</th>
			            <th width="100">操作</th>
			        </tr>
		        </thead>
		        <tbody id="news_option">
			        <?php foreach ($brandLists as $list) { ?>
			            <tr  class="text-c">
			                <td><?= $list['id'] ?></td>
			                <td><img src="../files/uploadFiles/<?= $list['photo'] ?>" width="80px" height="80px"></td>
			                <td><?= $list['name'] ?></td>
			                <td class="td-status"><?php if ($list['type'] == 1) { ?><label style="color:green;">是</label><?php } else { ?>否<?php } ?></td>
			                <td class="obj_1 td-manage">
			                    <?php if ($list['type'] != '1') { ?>
	                        	<a style="text-decoration:none" onclick="admin_start(this,<?= $list['id'] ?>)" href="javascript:;" title="推荐">
	                            	<i class="Hui-iconfont">&#xe615;</i>
	                            </a>
	                            <?php } else { ?>
	                            <a style="text-decoration:none" onClick="admin_stop(this,<?= $list['id'] ?>)" href="javascript:;" title="取消推荐">
	                                <i class="Hui-iconfont">&#xe631;</i>
	                            </a>
	                            <?php } ?>
	                            <a title="编辑" href="../Brand/addBrandPage?bid=<?= $list['id'] ?>" class="ml-5" style="text-decoration:none">
	                                <i class="Hui-iconfont">&#xe6df;</i>
	                            </a>
	                            <a title="删除" href="javascript:;" onclick="admin_del(this,<?= $list['id'] ?>)" class="ml-5" style="text-decoration:none">
	                                <i class="Hui-iconfont">&#xe6e2;</i>
	                            </a>
			                </td>
			            </tr>
			        <?php } ?>
		        </tbody>
            </table>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <?= $this->assets->outputJs('js1') ?>
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        <?= $this->assets->outputJs('js2') ?>
        <script>
	        $('#userListDataTables').DataTable({
	            bSort: true,      /*是否排序*/
	            bPaginate: true,  /*是否分页*/
	            bFilter: true,    /*是否查询*/
	            bInfo: true,      /*是否显示基本信息*/ 
	        });
	        
            /*删除*/
            function admin_del(obj, id) {
                layer.confirm('确认要删除吗？',
                function(index) {
                	$.post('../Brand/delBrand', {'bid':id}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").remove();
                            layer.msg('已删除!', { icon: 1,time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*取消推荐*/
            function admin_stop(obj, id) {
                layer.confirm('确认要取消推荐吗？',
                function(index) {
                    $.post('../Brand/barndTj', {'id':id, 'type':'0'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="推荐" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('否');
                            $(obj).remove();
                            layer.msg('已取消推荐!', { icon: 5, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*推荐*/
            function admin_start(obj, id) {
                layer.confirm('确认要推荐吗？',
                function(index) {
                	$.post('../Brand/barndTj', {'id':id, 'type':'1'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="取消推荐" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<font style="color:#090">是</font>');
                            $(obj).remove();
                            layer.msg('已推荐!', { icon: 6, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 6, time: 1000 });
                    });
                });
            }
        </script>
    </body>
</html>