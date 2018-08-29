<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="Bookmark" href="/favicon.ico">
        <link rel="Shortcut Icon" href="/favicon.ico" />
        <!--[if lt IE 9]>
            <script type="text/javascript" src="lib/html5shiv.js"></script>
            <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->
        
        {{ assets.outputCss() }}
        {{ assets.outputJs() }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>活动专区配置</title>
        <style>
        	.choosePhotoImg{ width:180px;height:120px; }
			.choosePhotoIpt{ display:none; }
        </style>
    </head>
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
        		<i class="Hui-iconfont">&#xe67f;</i> 首页 
        		<span class="c-gray en">&gt;</span> 营销 
        		<span class="c-gray en">&gt;</span> 活动专区配置 
        		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
        			<i class="Hui-iconfont">&#xe68f;</i>
        		</a>
        	</div>
        </nav>
        <div class="page-container">
            <form id="activityArea" class="form form-horizontal">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">专区名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="{{aaconf['zqname']}}" placeholder="专区名称" id="zqname" name="zqname" style="width:50%">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">标题名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="{{aaconf['btname']}}" placeholder="标题名称" id="btname" name="btname" style="width:50%">
					</div>
				</div>
				<div class="row cl"><!-- 主区配置 -->
					<label class="form-label col-xs-4 col-sm-3">主区配置：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="hui-form-radios" style="line-height:38px;">
					        <input type="radio" value="1" name="ztype" class="ztype" id="zg1" onchange="showSelectRes('zproiddiv-c');" {% if aaconf['ztype']=='1' %}checked="checked"{% endif %} /><label for="zg1">拼团更多</label>
					        <input type="radio" value="2" name="ztype" class="ztype" id="zg2" onchange="showSelectRes('zproiddiv-c');" {% if aaconf['ztype']=='2' %}checked="checked"{% endif %} /><label for="zg2">秒杀更多</label>
					        <input type="radio" value="3" name="ztype" class="ztype" id="zg3" onchange="showSelectRes('zproiddiv-c');" {% if aaconf['ztype']=='3' %}checked="checked"{% endif %} /><label for="zg3">砍价更多</label>
					        <input type="radio" value="4" name="ztype" class="ztype" id="zg4" onchange="showSelectRes('zproiddiv-o');" {% if aaconf['ztype']=='4' %}checked="checked"{% endif %} /><label for="zg4">自定义地址</label>
					    </div>
						<div class="row cl" id="zproiddiv" style="display:none;">
							<label class="form-label col-xs-4 col-sm-1" style="width:90px;">产品id：</label>
							<div class="formControls col-xs-8 col-sm-9">
								<input type="text" class="input-text" value="{{aaconf['zproid']}}" placeholder="产品id" id="zproid" name="zproid" style="width:100px">
							</div>
						</div>
						<img onclick="cppvw('photo_l','photolPvw');" id="photolPvw" src="{% if aaconf['zphoto'] %}../files/uploadFiles/{{ aaconf['zphoto'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:125px;height:200px"  >
						<input id="photo_l" class="choosePhotoIpt" name="photo_l" hphoto="{% if aaconf['id'] %}1{% else %}0{% endif %}" accept="image/*" type="file" />
					</div>
				</div>
				<div class="row cl"><!-- 右上配置 -->
					<label class="form-label col-xs-4 col-sm-3">右上配置：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="hui-form-radios" style="line-height:38px;">
					        <input type="radio" value="1" name="rttype" class="rttype" id="ltg1" onchange="showSelectRes('rtproiddiv-c');" {% if aaconf['rttype']=='1' %}checked="checked"{% endif %} /><label for="ltg1">拼团更多</label>
					        <input type="radio" value="2" name="rttype" class="rttype" id="ltg2" onchange="showSelectRes('rtproiddiv-c');" {% if aaconf['rttype']=='2' %}checked="checked"{% endif %} /><label for="ltg2">秒杀更多</label>
					        <input type="radio" value="3" name="rttype" class="rttype" id="ltg3" onchange="showSelectRes('rtproiddiv-c');" {% if aaconf['rttype']=='3' %}checked="checked"{% endif %} /><label for="ltg3">砍价更多</label>
					        <input type="radio" value="4" name="rttype" class="rttype" id="ltg4" onchange="showSelectRes('rtproiddiv-o');" {% if aaconf['rttype']=='4' %}checked="checked"{% endif %} /><label for="ltg4">自定义地址</label>
					    </div>
						<div class="row cl" id="rtproiddiv" style="display:none;">
							<label class="form-label col-xs-4 col-sm-1" style="width:90px;">产品id：</label>
							<div class="formControls col-xs-8 col-sm-9">
								<input type="text" class="input-text" value="{{aaconf['rtproid']}}" placeholder="产品id" id="rtproid" name="rtproid" style="width:100px">
							</div>
						</div>
						<img onclick="cppvw('photo_rt','photortPvw');" id="photortPvw" src="{% if aaconf['rtphoto'] %}../files/uploadFiles/{{ aaconf['rtphoto'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:125px;height:90px"  >
						<input id="photo_rt" class="choosePhotoIpt" name="photo_rt" hphoto="{% if aaconf['id'] %}1{% else %}0{% endif %}" accept="image/*" type="file" />
					</div>
				</div>
				<div class="row cl"><!-- 右下配置 -->
					<label class="form-label col-xs-4 col-sm-3">右下配置：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="hui-form-radios" style="line-height:38px;">
					        <input type="radio" value="1" name="rbtype" class="rbtype" id="lbg1" onchange="showSelectRes('rbproiddiv-c');" {% if aaconf['rbtype']=='1' %}checked="checked"{% endif %} /><label for="lbg1">拼团更多</label>
					        <input type="radio" value="2" name="rbtype" class="rbtype" id="lbg2" onchange="showSelectRes('rbproiddiv-c');" {% if aaconf['rbtype']=='2' %}checked="checked"{% endif %} /><label for="lbg2">秒杀更多</label>
					        <input type="radio" value="3" name="rbtype" class="rbtype" id="lbg3" onchange="showSelectRes('rbproiddiv-c');" {% if aaconf['rbtype']=='3' %}checked="checked"{% endif %} /><label for="lbg3">砍价更多</label>
					        <input type="radio" value="4" name="rbtype" class="rbtype" id="lbg4" onchange="showSelectRes('rbproiddiv-o');" {% if aaconf['rbtype']=='4' %}checked="checked"{% endif %} /><label for="lbg4">自定义地址</label>
					    </div>
						<div class="row cl" id="rbproiddiv" style="display:none;">
							<label class="form-label col-xs-4 col-sm-1" style="width:90px;">产品id：</label>
							<div class="formControls col-xs-8 col-sm-9">
								<input type="text" class="input-text" value="{{aaconf['rbproid']}}" placeholder="产品id" id="rbproid" name="rbproid" style="width:100px">
							</div>
						</div>
						<img onclick="cppvw('photo_rb','photorbPvw');" id="photorbPvw" src="{% if aaconf['rbphoto'] %}../files/uploadFiles/{{ aaconf['rbphoto'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:125px;height:90px"  >
						<input id="photo_rb" class="choosePhotoIpt" name="photo_rb" hphoto="{% if aaconf['id'] %}1{% else %}0{% endif %}" accept="image/*" type="file" />
					</div>
				</div>
				
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提 交&nbsp;&nbsp;" onClick="subData()">
						<input id="id" name="id" type="hidden" value="{{aaconf['id']}}">
					</div>
				</div>
			</form>
        </div>
        <script>
        	$(document).ready(function(){
        		if ($('#zg4').attr("checked")=="checked") showSelectRes('zproiddiv-o');
				if ($('#ltg4').attr("checked")=="checked") showSelectRes('rtproiddiv-o');
  	　　			if ($('#lbg4').attr("checked")=="checked") showSelectRes('rbproiddiv-o');
        	});
        	function showSelectRes(str){
        		var str = str.split('-');
        		if (str[1] == 'o') $('#'+str[0]).show();
        		else $('#'+str[0]).hide();
        	}
        	
        	function subData(){
        		var zqname = $('#zqname').val();
        		var btname = $('#btname').val();
        		var ztype = $("input[name='ztype']:checked").val();
        		var zproid = $('#zproid').val();
        		var photo_l = $('#photo_l').attr('hphoto');

        		var rttype = $("input[name='rttype']:checked").val();
        		var rtproid = $('#rtproid').val();
        		var photo_rt = $('#photo_rt').attr('hphoto');
        		
        		var rbtype = $("input[name='rbtype']:checked").val();
        		var rbproid = $('#rbproid').val();
        		var photo_rb = $('#photo_rb').attr('hphoto');
        		
        		if (!zqname) { layer.msg('请填写专区名称!', {  }); return false; }
        		else if (!btname) { layer.msg('请填写标题名称!', {  }); return false; }
        		else if (!ztype) { layer.msg('请选择专区类型!', {  }); return false; }
        		else if (ztype==4 && !zproid) { layer.msg('请填写产品id!', {  }); return false; }
        		else if (photo_l==0 && !$('#photo_l').val()) { layer.msg('请选择主区图片!', {  }); return false; }
        		else if (!rttype) { layer.msg('请选择右上类型!', {  }); return false; }
        		else if (rttype==4 && !rtproid) { layer.msg('请填写产品id!', {  }); return false; }
        		else if (photo_rt==0 && !$('#photo_rt').val()) { layer.msg('请选择右上图片!', {  }); return false; }
        		else if (!rbtype) { layer.msg('请选择右下类型!', {  }); return false; }
        		else if (rbtype==4 && !rbproid) { layer.msg('请填写产品id!', {  }); return false; }
        		else if (photo_rb==0 && !$('#photo_rb').val()) { layer.msg('请选择右下区图片!', {  }); return false; }
        		
        		var uploadFormData = new FormData($('#activityArea')[0]);
	    		$.ajax({
        	        url:'../Aaconf/aaEdit',
        	        type:"POST",
        	        contentType: false,
                    processData: false,
        	        data:uploadFormData,
        	        success: function(data) {
        	        	data = JSON.parse(data);
        	        	if (data.status == 1){
        	        		$('#id').val(data.id);
	        				layer.msg('操作成功!', { icon: 6, time: 1000 });
	        			}else {
	        				layer.msg(data.err, { icon: 5, time: 1000 });
	        			}
        	        }
        	    });
        	}
        
        
	        /* 选择图片预览 */
	    	function cppvw (input, photo) {
	    		$("#"+input).click();
	    		$("#"+input).on("change",function(){
	    			var objUrl = getObjectURL(this.files[0]) ;
	    			if (objUrl) {
	    				$("#"+photo).attr("src", objUrl) ;
	    			}
	    		});
	    	}
	    	/* 建立一個可存取到該file的url */
	    	function getObjectURL(file) {
	    		var url = null ;
	    		if (window.createObjectURL!=undefined) {
	    			url = window.createObjectURL(file) ;
	    		} else if (window.URL!=undefined) {
	    			url = window.URL.createObjectURL(file) ;
	    		} else if (window.webkitURL!=undefined) {
	    			url = window.webkitURL.createObjectURL(file) ;
	    		}
	    		return url;
	    	}
        </script>
    </body>
</html>