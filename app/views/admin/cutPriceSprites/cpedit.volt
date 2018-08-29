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
        
        {{ assets.outputCss('css1') }}
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        {{ assets.outputCss('css2') }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>店铺管理</title>
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
        </style>
    </head>
    <script>
		var choosePros = Array();
		function win_open(url, width, height){
			height == null ? height=500 : height;
			width == null ?  width=600 : width;
			var myDate = new Date();
			window.open(url,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
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
        /*输入验证*/
        function inputNumVerify(id){
        	var reg = /\d+/g;
        	var num = $('#'+id).val().match(reg)?parseInt($('#'+id).val().match(reg)):0;
        	if (id == 'friends'){/*需坎价人数*/
        		$('#'+id).val(num>99?99:num);
        	}else if (id == 'low_price'){/*最低价*/
        		$('#'+id).val(num);
        	}
        }
        
	</script>
    <body style="min-height:auto">
        <div class="page-container">
        	<form class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="{{cpInfo['name']}}" placeholder="活动名称" id="name" name="name" style="width:200px">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动时间：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm'})" class="input-text Wdate" placeholder="开始时间" 
		            	name="stime" id="stime" value="{{cpInfo['stime']}}" style="width:160px;" {% if type=='edit' %}disabled="disabled" readonly="readonly"{% endif %}>
		            	至
		            	<input type="text" onfocus="WdatePicker({ dateFmt: 'yyyy-MM-dd HH:mm',minDate:'#F{$dp.$D(\'stime\')}' })" placeholder="失效时间"
		            	id="etime" name="etime" value="{{cpInfo['etime']}}" class="input-text Wdate" style="width:160px;" {% if cpInfo['status']=='S3' %}disabled="disabled" readonly="readonly"{% endif %}>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">砍价模式：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="radio-box">
						    <input type="radio" class="cp_type" name="cp_type" value="1" {% if !cpInfo['cptype'] or cpInfo['cptype']=='1' %} checked="checked" {% endif %}>
						    <label for="radio-1">砍价到底才可购买</label>
						</div>
						<div class="radio-box" style="margin-left:20px">
						    <input type="radio" class="cp_type" value="2" name="cp_type" {% if cpInfo['cptype']=='2' %} checked="checked" {% endif %}>
						    <label for="radio-2">无需砍价到底即可购买</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">需坎次数：</label>
					<div class="formControls col-xs-8 col-sm-9">
						预计需要&nbsp;&nbsp;
						<input type="text" onInput="inputNumVerify(this.id)" class="input-text" value="{{cpInfo['friends']}}" id="friends" name="friends" style="width:50px;text-align:center;">
						&nbsp;&nbsp;个好友帮砍后才能砍到底价
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">商品低价：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" onInput="inputNumVerify(this.id)" class="input-text" value="{{cpInfo['low_price']}}" id="low_price" name="low_price" style="width:50px;text-align:center;">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">活动商品：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div id="pd_slt"></div>
					</div>
				</div>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提 交&nbsp;&nbsp;" onClick="subData()">
						<input class="btn radius" type="button" value="&nbsp;&nbsp;取 消&nbsp;&nbsp;" style="margin-left:30px;" onClick="layer_close();">
						<input id="cpId" name="cpId" type="hidden" value="{{cpId}}">
					</div>
				</div>
				
			</form>
        </div>
        <!--_footer 作为公共模版分离出去-->
        {{ assets.outputJs('js1') }}
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        {{ assets.outputJs('js2') }}
        <script>
        	{% if type=='add' %}
			var phtml = '<div class="jz_upload pd_choose jz_upload_normal" onclick="win_open(\'../CutPriceSprites/chooseProPage\',670,580)"><div class="jz_upload_icon"></div></div>';
			$('#pd_slt').html(phtml);
			{% else %}
			var phtml = '';
			{% endif %}

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
	        function getPros(proIds){
	        	choosePros = proIds.split(',');
	        	$.post('../CutPriceSprites/getPros', {proIds:proIds}, function(data){
	        		var datas = jQuery.parseJSON(data);
	        		if (datas.status == 1){
	        			var pros = datas.pros;
	        			
	        			{% if type=='add' %}phtml = '<div class="jz_upload pd_choose jz_upload_normal" onclick="win_open(\'../CutPriceSprites/chooseProPage?proIds='+proIds+'\',670,580)"><div class="jz_upload_icon"></div></div>';{% endif %}
	        			/*phtml += '<div class="jz_upload pd_choose jz_upload_normal" onclick="win_open(\'../CutPriceSprites/chooseProPage?proIds='+proIds+'\',670,580)"><div class="jz_upload_icon"></div></div>';*/
	        			
	        			for (var i=0; i<pros.length; ++i){
	        				phtml += '<div class="pro'+pros[i]['id']+'"><div class="pd_container"><div class="jz_editor img_editor" onMouseover="ieMin(this);" onMouseout="ieMout(this);">';
	        				phtml += '<div class="jz_img pd_img"><img src="../files/uploadFiles/'+pros[i]['photo_x']+'" class="jz_img_item"></div>';
	        				phtml += '<div class="jz_editor_layer"><i class="jz_editor_item jz_editor_del" onClick="editorDel(this);" proId="'+pros[i]['id']+'"></i>';
	        				phtml += '</div></div><span class="pd_name">'+pros[i]['name']+' </span></div></div>';
	        			}
	        			
	        			$('#pd_slt').html(phtml);
	        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	        	});
	        }
	        getPros("{{cpInfo['pro_ids']}}");

	        /*提交数据*/
	        function subData(){
	        	var name = $('#name').val();
	        	var stime = $('#stime').val();
	        	var etime = $('#etime').val();
	        	var friends = $('#friends').val();
	        	var lowPrice = $('#low_price').val();
	        	var cpId = $('#cpId').val();
	        	var proIds = choosePros.join(',');
	        	var type = "{{type}}";
	        	var cpType = $(".cp_type:radio:checked").val();
	        	if (!name || !stime || !etime || !friends || !lowPrice || !proIds){
	        		layer.msg('请先完整填写数据', function(){ }); return false;
	        	}
	        	$.post('../CutPriceSprites/cpEdit', {cpId:cpId,name:name,stime:stime,
	        		etime:etime,cptype:cpType,friends:friends,low_price:lowPrice,
	        		pro_ids:proIds,type:type}, function(data){
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