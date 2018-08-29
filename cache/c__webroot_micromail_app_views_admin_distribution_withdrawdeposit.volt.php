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
	            <span class="c-gray en">&gt;</span>分销商提现
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
	        <div class="text-c"> 选择月：
				<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM'})" id="time" class="input-text Wdate" style="width:120px;margin-right:20px;">
				<button name="" id="query" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
			</div>
            <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="80">分销商</th>
			            <th width="40">日期</th>
			            <th width="40">提现金额</th>
			            <th width="60">生成时间</th>
			            <th width="60">申请时间</th>
			            <th width="60">提现时间</th>
			            <th width="40">提现状态</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($txList as $list) { ?>
                    <tr class="text-c">
                        <td><?= $list['id'] ?></td>
		                <td><?= $list['fxs']['name'] ?></td>
		                <td><?= $list['year'] ?>-<?= $list['month'] ?></td>
		                <td><?= $list['amount'] ?> 元</td>
		                <td><?= $list['addtime'] ?></td>
		                <td><?= $list['sqtxtime'] ?></td>
		                <td><?= $list['txtime'] ?></td>
		                <td class="td-status">
		                	<?php if ($list['status'] == 'S0') { ?>
		                		账单生成
		                	<?php } elseif ($list['status'] == 'S1') { ?>
		                		<label style="color:green;">申请提现</label>
		                	<?php } elseif ($list['status'] == 'S2') { ?>
		                		<label style="color:red;">拒绝提现</label>
		                	<?php } elseif ($list['status'] == 'S3') { ?>
		                		<label style="color:green;">已提现</label>
		                	<?php } ?>
		                </td>
                        <td class="td-manage">
                        	<a style="text-decoration:none" href="../Distribution/txdPage?msid=<?= $list['id'] ?>" title="提现">
								详情
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
	        
            /*歇业*/
            function sqtx(obj, id) {
                layer.confirm('确认申请提现？',
                function(index) {
                    $.post('../Distribution/sqtx', {'msid':id}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="sqtx(this,'+id+')" href="javascript:;" title="提现"><label style="color:red;">审核中</label></a>');
                            $(obj).parents("tr").find(".td-status").html('<label style="color:green;">申请提现</label>');
                            $(obj).remove();
                            layer.msg('申请成功!', { icon: 6, time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }
        </script>
    </body>
</html>