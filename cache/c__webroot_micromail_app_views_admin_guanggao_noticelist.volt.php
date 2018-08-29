<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/respond.min.js"></script>
    <![endif]-->
    
	<?= $this->assets->outputCss('css1') ?>
	<link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
	<?= $this->assets->outputCss('css2') ?>
      
    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>广告管理</title>
</head>
<body style="min-height:auto">
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 广告管理 <span class="c-gray en">&gt;</span> 全部公告 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    <table id="advList" class="table table-border table-bordered table-bg">
        <thead>
	        <tr class="text-c">
	            <th width="40">ID</th>
	            <th width="60">公告标题</th>
	            <th width="150">公告内容</th>
	            <th width="80">显示位置</th>
	            <th width="60">操作</th>
	        </tr>
        </thead>

        <tbody id="news_option">
        <?php foreach ($noticelist as $notice) { ?>
            <tr class="text-c">
                <td><?= $notice['id'] ?></td>
                <td><?= $notice['title'] ?></td>
                <td><?= $notice['content'] ?></td>
                <td>
                    <?php if ($notice['position'] == 1) { ?>
                    	<span class="label succ">首页顶部公告</span>
                    <?php } else { ?>
                        <span class="label err">其他</span>
                    <?php } ?>
                </td>
                <td class="obj_1">
                    <a title="编辑" href="../Guanggao/addNoticePage?notice_id=<?= $notice['id'] ?>" class="ml-5" style="text-decoration:none">
                  		<i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    <a title="删除" href="javascript:;" onclick="notice_del(this, <?= $notice['id'] ?>)" class="ml-5" style="text-decoration:none">
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
	$('#advList').DataTable({
	    bSort: true,      /*是否排序*/
	    bPaginate: true,  /*是否分页*/
	    bFilter: true,    /*是否查询*/
	    bInfo: true,      /*是否显示基本信息*/ 
	});
	
    function notice_del(obj, notice_id){
    	layer.confirm('确认要删除吗？',
		function(index) {
  			$.post('../Guanggao/noticeDel', {'notice_id':notice_id}, function(data){
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