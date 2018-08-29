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
        <nav class="navb">
        	<div class="breadcrumb">
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
		    <div class="text-c">
		        <input type="text" class="input-text" style="width:250px" placeholder="产品名称" id="name" value="">
		        <select class="inp_1 inp_6" id="tuijian">
		            <option value="">全部产品</option>
		            <option value="1" >推荐产品</option>
		            <option value="0" >非推荐产品</option>
		        </select>
		        <button type="button" class="btn btn-success" id="" name="" onclick="product_option(0);"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
		    </div>
		    <br>
            <table id="userListDataTables" class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="20">ID</th>
			            <th width="100">图片</th>
			            <th width="80">所属品牌</th>
			            <th width="180">产品名称</th>
			            <th width="40">价格/元</th>
			            <th width="40">人气</th>
			            <!-- <th width="40">属性(点击修改)</th> -->
			            <th width="20">推荐</th>
			            <th width="80">操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($products as $list) { ?>
                    <tr class="text-c">
                        <td><?= $list['id'] ?></td>
		                <td style="padding:3px 0;"><img src="../files/uploadFiles/<?= $list['photo_x'] ?>" width="80px" height="80px"/></td>
		                <td><?= $list['brand_id'] ?></td>
		                <td><?= $list['name'] ?></td>
		                <td><?= $list['price_yh'] ?></td>
		                <td><?= $list['renqi'] ?></td>
		                <!-- <td>
		                	<p id="new_<?= $list['id'] ?>"><?php if ($list['is_show'] == 1) { ?><a class="label blue" onclick="pro_new(<?= $list['id'] ?>,1)">新品上市<?php } else { ?><a class="label err" onclick="pro_new(<?= $list['id'] ?>,0);">非新品<?php } ?></a></p>
		                    <p id="hot_<?= $list['id'] ?>" style="margin-top:5px;"><?php if ($list['is_hot'] == 1) { ?><a class="label succ" onclick="pro_hot(<?= $list['id'] ?>,1)">热卖商品<?php } else { ?><a class="label err" onclick="pro_hot(<?= $list['id'] ?>,0);">非热卖<?php } ?></a></p>
		                    <p id="zk_{$v.id}" style="margin-top:5px;"><if condition="$v.is_sale eq 1"><a class="label fail" onclick="pro_zk({$v.id},1);">折扣商品<else /><a class="label err" onclick="pro_zk({$v.id},0);">非折扣</if></a></p>
		                </td> -->
		                <td class="td-status"><?php if ($list['type'] == 1) { ?><label style="color:green;">推荐</label><?php } ?></td>
                        <td class="td-manage">
                        	<?php if ($list['type'] != '1') { ?>
                        	<a style="text-decoration:none" onclick="admin_start(this,<?= $list['id'] ?>)" href="javascript:;" title="推荐">
                            	<i class="Hui-iconfont">&#xe615;</i>
                            </a>
                            <?php } else { ?>
                            <a style="text-decoration:none" onClick="admin_stop(this,<?= $list['id'] ?>)" href="javascript:;" title="取消推荐">
                                <i class="Hui-iconfont">&#xe631;</i>
                            </a>
                            <?php } ?>
                            <!-- <a title="编辑" href="../Product/paPage?pid=<?= $list['id'] ?>" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6df;</i>
                            </a> -->
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
	            bAutoWidth: false, /*是否自动适应宽度*/
	        });
	        function product_option(page){

	            var pid = $('#pid').val();
	            if(pid == ''){
	                pid = $('#ppid').val();
	            }
	            var obj={
	                "name": $("#name").val(),
	                "shop_id": pid,
	                "tuijian": $("#tuijian").val()
	            }
	        }
	        
	        /* 新品设置 */
			function pro_new(pro_id, type){
	            if (!pro_id) {eturn;}
	            $.post("../Product/proNew",{pro_id:pro_id, type:type},function(data){
	            	
	                if (data.status==1) {
	                    if (type==1) {
	                        document.getElementById('new_'+pro_id).innerHTML='<a class="label err" onclick="pro_new('+pro_id+',0)">非新品</a>';
	                    }else{
	                        document.getElementById('new_'+pro_id).innerHTML='<a class="label blue" onclick="pro_new('+pro_id+',1)">新品上市</a>';
	                    }
	                }else{
	                	layer.msg(data.msg, { icon: 5, time: 1000 });
	                    return false;
	                }
	            },'json');
	        }
			
			/* 热销设置 */
		    function pro_hot(pro_id,type){
		        if (!pro_id) {return;}
		        $.post("../Product/proHot",{pro_id:pro_id, type:type},function(data){
		            if (data.status==1) {
		                if (type==1) {
		                    document.getElementById('hot_'+pro_id).innerHTML='<a class="label err" onclick="pro_hot('+pro_id+',0);">非热卖</if></a>';
		                }else{
		                    document.getElementById('hot_'+pro_id).innerHTML='<a class="label succ" onclick="pro_hot('+pro_id+',1);">热卖商品</if></a>';
		                }
		            }else{
		                alert('操作失败，请稍后再试！');
		                return false;
		            }
		        },'json');
		    }
	        
	        
            /*删除*/
            function admin_del(obj, id) {
                layer.confirm('确认要删除吗？',
                function(index) {
                	$.post('../Product/proDel', {'id':id}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		$(obj).parents("tr").remove();
                            layer.msg('已删除!', { icon: 1,time: 1000 });
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
                });
            }

            /*编辑*/
            function admin_edit(title, url, id, w, h) {
                layer_show(title, url, w, h);
            }
            /*取消推荐*/
            function admin_stop(obj, id) {
                layer.confirm('确认要取消推荐吗？',
                function(index) {
                    $.post('../Product/proTj', {'id':id, 'type':'0'}, function(data){
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

            /*推荐*/
            function admin_start(obj, id) {
                layer.confirm('确认要推荐吗？',
                function(index) {
                	$.post('../Product/proTj', {'id':id, 'type':'1'}, function(data){
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