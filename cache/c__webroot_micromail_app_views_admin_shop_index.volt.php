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
        
        <?= $this->assets->outputCss('css1') ?>
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        <?= $this->assets->outputCss('css2') ?>
        
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
	            <span class="c-gray en">&gt;</span>全部店铺
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
			            <th width="100">Logo</th>
			            <th width="80">店铺名称</th>
			            <th width="80">负责人</th>
			            <th width="40">创建日期</th>
			            <th width="40">店铺介绍</th>
			            <th width="40">评分等级</th>
			            <th width="20">联系电话</th>
			            <th width="20">状态</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($shopList as $list) { ?>
                    <tr class="text-c">
                        <td><?= $list['id'] ?></td>
		                <td style="padding:3px 0;">
		                	<img src="../files/uploadFiles/<?= $list['logo'] ?>" width="80px" height="80px"/>
		                </td>
		                <td><?= $list['name'] ?></td>
		                <td><?= $list['uname'] ?></td>
		                <td><?= $list['addtime'] ?></td>
		                <td><?= $list['intro'] ?></td>
		                <td><?= $list['grade'] ?></td>
		                <td><?= $list['tel'] ?></td>
		                <td class="td-status">
		                	<?php if ($list['status'] == '1') { ?>
		                		<label style="color:green;">正常</label>
		                	<?php } else { ?>
		                		停业
		                	<?php } ?>
		                </td>
                        <td class="td-manage">
                        	<?php if ($list['status'] != '1') { ?>
                        	<a style="text-decoration:none" onclick="admin_start(this,<?= $list['id'] ?>)" href="javascript:;" title="营业">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            <?php } else { ?>
                            <a style="text-decoration:none" onClick="admin_stop(this,<?= $list['id'] ?>)" href="javascript:;" title="歇业">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            <?php } ?>
                            <a title="编辑" href="#" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a>
                            <a title="查看商品" href="#" class="ml-5" onClick="shopPro('<?= $list['name'] ?>--商品列表','../ShopManagement/spListPage?sid=<?= $list['id'] ?>',<?= $list['id'] ?>)" href="javascript:;" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe620;</i>
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
	        
            /*编辑*/
            function admin_edit(title, url, id, w, h) {
                layer_show(title, url, w, h);
            }
            /*查看店铺商品*/
            function shopPro(title, url, id, w, h){
            	var index = layer.open({
            		type: 2,
            		title: title,
            		content: url
            	});
            	layer.full(index);
            }
            /*歇业*/
            function admin_stop(obj, id) {
                layer.confirm('确认该店铺歇业？',
                function(index) {
                    $.post('../ShopManagement/shopStatus', {'id':id, 'type':'0'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="营业" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('停业');
                            $(obj).remove();
                            layer.msg('已取歇业!', { icon: 5, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*营业*/
            function admin_start(obj, id) {
                layer.confirm('确认允许营业？',
                function(index) {
                	$.post('../ShopManagement/shopStatus', {'id':id, 'type':'1'}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="歇业" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<font style="color:#090">正常</font>');
                            $(obj).remove();
                            layer.msg('已允许!', { icon: 6, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 6, time: 1000 });
                    });
                });
            }
        </script>
    </body>
</html>