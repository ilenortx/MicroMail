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
        <title>产品列表</title>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 优惠券管理 <span class="c-gray en">&gt;</span> 全部优惠券 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
        <div class="page-container">
		    <table id="vouList" class="table table-border table-bordered table-bg">
		        <thead>
			        <tr class="text-c">
			            <th width="40">ID</th>
			            <th width="100">标题</th>
			            <th width="100">满减金额</th>
			            <th width="130">开始时间</th>
			            <th width="130">过期时间</th>
			            <th width="50">所需积分</th>
			            <th width="50">发行数量</th>
			            <th width="50">已领取</th>
			            <th width="100">使用属性</th>
			            <th width="80">操作</th>
			        </tr>
		        </thead>

		        <tbody id="news_option">
		        <!-- 遍历 -->
		        <?php foreach ($vouLists as $list) { ?>
		            <tr class="text-c">
		                <td><?= $list['id'] ?></td>
		                <td><?= $list['title'] ?></td>
		                <td>满<span style="color:red;"><?= $list['full_money'] ?></span>减<span style="color:red;"><?= $list['amount'] ?></span></td>
		                <td><?= $list['start_time'] ?></td>
		                <td><?= $list['end_time'] ?></td>
		                <td><if condition="$v.point eq 0">免费领取<else /><?= $list['point'] ?></if></td>
		                <td><?= $list['count'] ?></td>
		                <td><?= $list['receive_num'] ?></td>
		                <td>
		                    <?php if ($list['proid'] == 'all') { ?><a class="label succ">店内通用</a><?php } else { ?><a class="label fail">限定商品</a><?php } ?>
		                </td>
		                <td>
		                    <a href="../Voucher/addPage?vid=<?= $list['id'] ?>">修改</a> |
		                    <a onclick="delVou(this,<?= $list['id'] ?>)">删除</a>
		                </td>
		            </tr>
		        <?php } ?>
		        <!-- 遍历 -->
		        </tbody>
		    </table>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <?= $this->assets->outputJs('js1') ?>
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        <?= $this->assets->outputJs('js2') ?>
        <script>
	        $('#vouList').DataTable({
	            bSort: true,      /*是否排序*/
	            bPaginate: true,  /*是否分页*/
	            bFilter: true,    /*是否查询*/
	            bInfo: true,      /*是否显示基本信息*/ 
	        });
	        
	        function delVou(obj, id){
	            layer.confirm('确认要删除吗？', function(index) {
	           		$.post('../Voucher/delVou', {'vid':id}, function(data){
	              		var datas = jQuery.parseJSON(data);
	                 	if (datas.status == 1){
	                     	$(obj).parents("tr").remove();
	                     	layer.msg('已删除!', { icon: 1,time: 1000 });
	                 	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	             	});
	        	});
	        }
	        
        </script>
    </body>
</html>