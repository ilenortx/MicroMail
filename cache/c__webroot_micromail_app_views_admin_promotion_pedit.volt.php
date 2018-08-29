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
        <?= $this->assets->outputJs() ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <style>
        	.col-sm-3{ width: 110px; padding: 0px; }
        	.radio-box{ padding:0px; }
        	#pd_slt .pd_choose { display:inline-block;margin:18px 0 0 18px; }
        	#pd_slt{ width:605px; height:258px; border:1px solid #e3e2e8; border-radius:2px;position:relative;box-sizing:border-box;display:flex;flex-flow:row wrap;overflow-y:auto; }
        	.jz_upload { box-sizing:border-box;width:78px;height:78px;border:1px dashed #ccc;line-height:76px;color:#666;cursor:pointer;text-align:center;overflow:hidden; }
        	.jz_upload_icon { display:inline-block;width:32px;height:35px;vertical-align:middle;background: url(../img/coustom/component.png?v=201806151520) no-repeat -323px -33px; }
        	
			#pd_slt .pd_container{width:78px;height:78px;display:inline-block;margin:18px 0 0 18px}
			.jz_editor{position:relative;height:100%}
			.jz_img{box-sizing:border-box;height:100%;border:1px solid #e7e7eb;text-align:center;font-size:0;line-height:0}
			.jz_img_item{display:inline-block;width:auto;height:auto;max-width:100%;max-height:100%;vertical-align:middle}
			.jz_editor_layer{display:none;position:absolute;width:100%;height:100%;border:1px solid #5874d8;left:0;top:0;box-sizing:border-box}
			.jz_editor_del{width:14px;height:14px;position:absolute;right:-5px;top:-5px;background:url(../img/coustom/component.png?v=201806151520) no-repeat -435px 0;cursor:pointer}
			#pd_slt .pd_name{display:inline-block;width:78px;height:18px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        	.tip { line-height:40px;font-size:13px;color:rgb(255, 142, 30);text-align:center;width:600px;background:rgb(255, 245, 220);padding:0px 15px;margin:auto auto 20px; }
        	.page-container { margin-top: 0px;}
        	.helpInfo { color:#999; }
        	
        	.jz_img { box-sizing: border-box;width:78px;height:78px;border:1px solid #e7e7eb;text-align:center;font-size:0;line-height:0; }
        	.jz_img_item { display:inline-block;width:auto;height:auto;max-width:100%;max-height:100%;vertical-align:middle; }
        	.jz_editor { width:78px;height:78px;display:none; }
        	.jz_editor_layer { display:none;position:absolute;width:100%;height:100%;border:1px solid #5874d8;left:0;top:0;box-sizing:border-box; }
        	.jz_editor_del { width: 14px;height:14px;position:absolute;right:-5px;top:-5px;background:url(../img/coustom/component.png?v=201806151520) no-repeat -435px 0;cursor:pointer; }
        	.jz_editor_update { width:23px;height:23px;position:absolute;right:0;bottom:0;background:url(../img/coustom/component.png?v=201806151520) no-repeat -684px -44px;cursor:pointer;background-color:#557ce1; }
        </style>
    </head>
    <script>
		var choosePro = 0;
		function win_open(url, width, height){
			height == null ? height=500 : height;
			width == null ?  width=600 : width;
			var myDate = new Date();
			window.open(url+'?proId='+choosePro,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
		}

        function ieMin(obj){
        	$(obj).find('.jz_editor_layer').css({'display':'block'});
        }
        function ieMout(obj){
        	$(obj).find('.jz_editor_layer').css({'display':'none'});
        }
        function editorDel(obj){
        	var proId = $(obj).attr('proId');
        	$('#pd_slt').find('.pro'+proId).remove();
        	choosePros.splice($.inArray(proId, choosePros),1);
        };
	</script>
    <body style="min-height:auto">
        <div class="page-container">
        	<form class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="<?= $pInfo['name'] ?>" placeholder="活动名称" id="name" name="name" style="width:200px">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动商品：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="jz_upload pd_choose jz_upload_normal" onclick="win_open('../Promotion/chooseProPage',670,580)"><div class="jz_upload_icon"></div></div>
						<div class="jz_editor img_editor">
							<div class="jz_img">
								<img src="" class="jz_img_item">
							</div>
							<div class="jz_editor_layer">
								<i class="jz_editor_item jz_editor_del"></i>
								<i class="jz_editor_item jz_editor_update" onclick="win_open('../Promotion/chooseProPage',670,580)"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">商品名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div id="pro_name"></div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">促销价：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="<?= $pInfo['pprice'] ?>" placeholder="活动名称" id="pprice" name="pprice" style="width:200px">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动时间：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH'})" class="input-text Wdate" placeholder="开始时间" 
		            	name="stime" id="stime" value="<?= $pInfo['stime'] ?>" style="width:160px;" <?php if ($pId) { ?>disabled="disabled" readonly="readonly"<?php } ?>>
		            	至
		            	<input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH',minDate:'#F{$dp.$D(\'stime\')}' })" placeholder="失效时间"
		            	id="etime" name="etime" value="<?= $pInfo['etime'] ?>" class="input-text Wdate" style="width:160px;">
					</div>
				</div>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提 交&nbsp;&nbsp;" onClick="subData()">
						<input class="btn radius" type="button" value="&nbsp;&nbsp;取 消&nbsp;&nbsp;" style="margin-left:30px;" onClick="layer_close();">
						<input id="pId" type="hidden" value="<?= $pId ?>">
					</div>
				</div>
			</form>
        </div>
        
        <script>
	        /*选择商品*/
	        function choosePro(title,url,id,w,h){
	        	var index = layer.open({
		    		type: 2,
		    		title: title,
		    		content: url
		    	});
		    	layer.full(index);
	        }
	        
	        /*从服务加载选择商品*/
	        function getPros(proId){
	        	if (proId > 0){
		        	$.post('../GroupBooking/getPro', {proId:proId}, function(data){
		        		var datas = jQuery.parseJSON(data);
		        		if (datas.status == 1){
			        		choosePro = proId;
		        			var pro = datas.pro;
		        			
		        			$('.jz_img_item').attr('src', "../files/uploadFiles/"+pro['photo_x']);
		        			$('#pro_name').html(pro['name']);
		        			$('.jz_upload').css({'display':'none'});
		        			$('.jz_editor').css({'display':'block'});
		        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
		        	});
	        	}
	        }
	        getPros("<?= $pInfo['pro_id'] ?>");
	        
	        <?php if ($type == 'add') { ?>
	        $('.img_editor').mouseover(function(){
	        	$('.jz_editor_layer').css({'display':'block'});
	        });
	        $('.img_editor').mouseout(function(){
	        	$('.jz_editor_layer').css({'display':'none'});
	        });
	        $('.jz_editor_del').click(function(){
	        	choosePro = 0;
	        	$('.jz_upload').css({'display':'block'});
    			$('.jz_editor').css({'display':'none'});
	        });
	        <?php } ?>
	        /*提交数据*/
	        function subData(){
	        	var pId = $('#pId').val();
	        	var name = $('#name').val();
	        	var stime = $('#stime').val();
	        	var etime = $('#etime').val();
	        	var pprice = $('#pprice').val();
	        	var proId = choosePro;
	        	var type = "<?= $type ?>";
	        	if (!name || !stime || !etime || !proId || !pprice){
	        		layer.msg('请先完整填写数据', function(){ }); return false;
	        	}
	        	$.post('../Promotion/pEdit', {pId:pId,name:name,stime:stime,
	        		etime:etime,pprice:pprice,proId:proId,type:type}, function(data){
	        		var datas = jQuery.parseJSON(data);
	        		
	        		if (datas.status == 1){
	                	window.parent.reloadData();
	                	layer_close();
	        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	        	});
	        }
	        
        </script>
    </body>
</html>