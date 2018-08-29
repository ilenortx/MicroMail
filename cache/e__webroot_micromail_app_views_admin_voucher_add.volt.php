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
	<script>
		function win_open(url, width, height){
			height == null ? height=600 : height;
			width == null ?  width=800 : width;
			var myDate = new Date();
			window.open(url,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
		}
	</script>
    <body>
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>优惠券管理<span class="c-gray en">&gt;</span><?php if ($vid) { ?><a href="../Voucher/index">全部优惠券</a> <span class="c-gray en">&gt;</span> 编辑优惠券 <?php } else { ?> 新增优惠券 <?php } ?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
		<div class="page-container">
		    <form class="form form-horizontal" action="../Voucher/vouSave" method="post" onsubmit="return ac_from();" enctype="multipart/form-data">
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券名称：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" placeholder="优惠券名称" name="title" id="title" value="<?= $vinfo['title'] ?>">
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开始时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		            	<input type="text" onfocus="WdatePicker()" class="input-text Wdate" placeholder="开始时间" 
		            	name="start_time" id="logmin" value="<?= $vinfo['start_time'] ?>">
		                <span class="tipText">优惠券的生效时间</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>失效时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		            	<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}' })" id="logmax" 
		            	placeholder="失效时间" name="end_time" value="<?= $vinfo['end_time'] ?>" class="input-text Wdate">
		                <span class="tipText">失效时间必须大于生效时间（当天晚上12点失效）</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>满减金额：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" placeholder="满减金额" name="full_money" id="full_money" value="<?= $vinfo['full_money'] ?>" >
		                <span class="tipText">使用时减免的金额</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠金额：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" placeholder="优惠金额"  name="amount" id="amount" value="<?= $vinfo['amount'] ?>" >
		                <span class="tipText">使用时减免的金额</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所需积分：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" name="point" id="point" value="<?= ($vinfo['point'] == 0 ? 0 : $vinfo['point']) ?>" >
		                <span class="tipText">会员领取时所需积分，默认0，免费领取</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>发行数量：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input type="text" class="input-text" placeholder="发行数量"  name="count" id="count" value="<?= $vinfo['count'] ?>" >
		                <span class="tipText">开团所需要达到的人数</span>
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>使用范围：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                <input class="input-text" id="proid" name="proid" value="<?= ($vinfo['proid'] == '' ? 'all' : $vinfo['proid']) ?>" readonly="readonly"/>
		                <input type="button" value="选择商品" class="btn btn-primary"  onclick="win_open('../Voucher/chooseProPage',1280,800)">
		                <br>
		                <span class="tipText">默认店铺内所有商品通用</span>
		            </div>
		        </div>
		
		        <?php if (($vinfo['proid'] != 'all' && $vinfo['proid'] != '' && $vinfo['pro_list'])) { ?>
		        <li>
		            <div class="d1">已选产品:</div>
		            <div>
		                <?php foreach ($vinfo['pro_list'] as $list) { ?>
		                    <img src="<?= $list ?>" width="100px" height="100px" />
		                <?php } ?>
		            </div>
		        </li>
		        <?php } ?>
		
		        <div class="row cl">
		            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
		                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" id="aaa_pts_web_s">
		                <?php if ($vinfo['id']) { ?><input type="hidden" name="id" id='id' value="<?= $vinfo['id'] ?>"><?php } ?>
		            </div>
		        </div>
		    </form>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <?= $this->assets->outputJs('js1') ?>
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        <?= $this->assets->outputJs('js2') ?>
        <script>
	        function ac_from(){
	
	            var full_money = document.getElementById("full_money").value;
	            var amount = document.getElementById("amount").value;
	            var count=document.getElementById("count").value;
	
	            if(/^\d+$/.test(count)==false) {
	                alert('请输入数字格式的发行数量！');
	                return false;
	            }
	
	            var fix_amountTest=/^(([1-9]\d*)|\d)(\.\d{1,2})?$/;
	            if(fix_amountTest.test(full_money)==false){
	                alert("请输入有效格式的满减金额！");
	                return false;
	            }
	
	            if(fix_amountTest.test(amount)==false){
	                alert("请输入有效格式的优惠金额！");
	                return false;
	            }
	        }
        </script>
    </body>
</html>