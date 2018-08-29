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
	            <span class="c-gray en">&gt;</span>分销商管理
	            <span class="c-gray en">&gt;</span>申请列表
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
			            <th width="100">申请人</th>
			            <th width="80">电话</th>
			            <th width="40">申请日期</th>
			            <th width="20">状态</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($sqList as $list) { ?>
                    <tr class="text-c">
                        <td><?= $list['id'] ?></td>
		                <td><?= $list['name'] ?></td>
		                <td><?= $list['phone'] ?></td>
		                <td><?= $list['addtime'] ?></td>
		                <td class="td-status">
		                	<?php if ($list['status'] == 'S0') { ?>
		                		<label style="color:green;">未审核</label>
		                	<?php } else { ?>
		                		<label style="color:red;">审核未通过</label>
		                	<?php } ?>
		                </td>
                        <td class="td-manage">
                            <a title="确认通过" href="javascript:;" onClick="audit(this, <?= $list['id'] ?>, 'S2')" class="ml-5" style="text-decoration:none">
								通过
                            </a>
                            <a title="驳回" href="#" class="ml-5" onClick="audit(this, <?= $list['id'] ?>, 'S1')" href="javascript:;" style="text-decoration:none">
								驳回
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
	            bInfo: false,      /*是否显示基本信息*/ 
	        });
	        
            /*审核*/
            function audit (obj, did, status) {
            	$.post('../Distribution/audit', {'id':did, 'status':status}, function(data){
                	var datas = jQuery.parseJSON(data);
                	if (datas.status == 1){
                		if (status == 'S2'){
                			$(obj).parents("tr").remove();
                		}else {
                			$(obj).parents("tr").find(".td-status").html('<label style="color:red;">审核未通过</label>');
                		}
                        layer.msg('操作成功!', { icon: 6, time: 1000 });
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                });
            }
        </script>
    </body>
</html>