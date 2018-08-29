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
        
        <?= $this->assets->outputCss() ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>店铺管理</title>
    </head>
    <body style="min-height:100%;min-width:1060px;">
        <nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>营销
	            <span class="c-gray en">&gt;</span>多人拼团
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container app">
            <!-- 顶部 -->
            <div class="plaque">
            	<span class="plaque_content img_slot"></span>
            	<span class="plaque_content verbose">
            		<span id="title">多人团购</span>
            		<span id="oem_ult_badge"></span>
            		<span id="trialTips"></span>
            		<span id="foolproof">基于分享和微信强大的关系链，可快速实现商品传播并促成下单，商家既能拓展销售渠道，也能快速成单卖出好货！</span>
					<button class="jz_button btn_compo jz_button__active" onclick="gbedit('新增团购','../GroupBooking/gbeditPage?gbId=&type=add','2','770','600')">
						<i class="jz_icon jz_icon_add"></i>
						<span class="jz_button_content">新增活动</span>
					</button>
				</span>
            </div>
        	
        	<!-- 主体 -->
        	<div class="gb_table">
        		<div class="tabPanel">
					<ul>
				       	<li class="tabLi selectedLi"> 所有团购 </li>
				      	<li class="tabLi"> 未开始 </li>
				     	<li class="tabLi"> 进行中 </li>
				        <li class="tabLi"> 已结束 </li>
				 		<li class="selectedLine" style="left: 0px;"> </li>
				   	</ul>
				</div>
        		
        		<!-- 所有砍价 -->
        		<div id="allGb">
        			<table id="gbTable" class="table table-border table-bordered table-bg table-hover table-sort">
		                <thead>
		                    <tr class="text-c">
					            <th width="20">操作</th>
					            <th width="100">活动名称</th>
					            <th width="100">有效时间</th>
					            <th width="50">活动状态</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	
		                </tbody>
		            </table>
        		</div>
        	</div>
        </div>
        
        <?= $this->assets->outputJs() ?>
        <script>
        	var qtype = 'all';
	        var cptable = $('#gbTable').DataTable({
	            bSort: true,      /*是否排序*/
	            bPaginate: true,  /*是否分页*/
	            bFilter: false,    /*是否查询*/
	            bInfo: true,      /*是否显示基本信息*/ 
	            ajax: {
	                url: "../GroupBooking/getGBList",
	                data: { qtype: qtype }
	            },
	            "columns": [
	                { "data": "eidt" },
	                { "data": "name" },
	                { "data": "time" },
	                { "data": "status" }
	            ]
	        });
	        
	        function reloadData(){
	        	cptable.settings()[0].ajax.data = { qtype: qtype };
	        	cptable.ajax.reload(function (json) {  });
		    }
	        
	        $('.tabLi').click(function(){
	        	var index = $('.tabLi').index(this);
	        	$('.tabLi').removeClass('selectedLi');
	        	$(this).addClass('selectedLi');
	        	$('.selectedLine').css("left",94*index+"px");
	        	
	        	qtype = index==0?'all':(index==1?'S1':(index==2?'S2':'S3'));
	        	
	        	reloadData();
	        });
	        
	        /*砍价编辑*/
	        function gbedit(title,url,id,w,h){
	        	layer_show(title,url,w,h);
	        }
	        
	        /*删除砍价*/
	        function gbDel(gbId){
	        	$.post('../GroupBooking/gbDel', {gbId:gbId}, function(data){
	        		var datas = jQuery.parseJSON(data);
	        		
	        		if (datas.status == 1){
	        			reloadData();
	        			layer.msg('操作成功', { icon: 6, time: 1000 });
	        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	        		
	        	});
	        }
	        
        </script>
    </body>
</html>