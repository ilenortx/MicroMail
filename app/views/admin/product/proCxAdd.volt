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
            <script type="text/javascript" src="__PUBLIC__/admin/lib/html5shiv.js"></script>
            <script type="text/javascript" src="__PUBLIC__/admin/lib/respond.min.js"></script>
        <![endif]-->
        
        {{ assets.outputCss() }}
        {{ assets.outputJs() }}
        
        <!--[if IE 6]>
            <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        
        <style>
        	.page-container{margin:0}
            .inp_2 {width: 770px;height: 300px;} .inp_1 {border-radius: 2px;border: 1px solid #b9c9d6;float: left;} li {list-style-type:none;} .dx1{float:left; margin-left: 17px; margin-bottom:10px; } .dx2{color:#090; font-size:16px; border-bottom:1px solid #CCC; width:100% !important; padding-bottom:8px;} .dx3{width:120px; margin:5px auto; border-radius: 2px; border: 1px solid #b9c9d6; display:block;} .dx4{border-bottom:1px solid #eee; padding-top:5px; width:100%;} .img-err { position: relative; top: 2px; left: 82%; color: white; font-size: 20px; border-radius: 16px; background: #c00; height: 21px; width: 21px; text-align: center; line-height: 20px; cursor:pointer; } .btnp{ height: 25px; width: 60px; line-height: 24px; padding: 0 8px; background: #24a49f; border: 1px #26bbdb solid; border-radius: 3px; color: #fff; display: inline-block; text-decoration: none; font-size: 13px; outline: none; -webkit-box-shadow: #666 0px 0px 6px; -moz-box-shadow: #666 0px 0px 6px; } .btnp:hover{ border: 1px #0080FF solid; background:#D2E9FF; color: red; -webkit-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; -moz-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; } .cls{ background: #24a49f; }
        	.val-table{width:400px;}
        	.val-table-title{height:30px;text-align:center;font-size:15px;background-color:#EEF3FE;}
        	.val-table-title th{border:1px solid #B5C8EB;text-align:center;}
        	.values{width:398px;height:200px;overflow-y:auto;overflow-x:hidden;border:1px solid #B5C8EB;border-top:none;}
        	.var-values-table{width:398px;}
        	.var-values-table tr{height:30px;}
        	.faiButton{display:inline-block;margin:0;outline:0;cursor:pointer;text-align:center;text-decoration:none;font-size:12px;margin:0;padding:0 10px!important;_padding:0 4px;height:23px;_height:22px;line-height:19px;_line-height:22px;border:1px solid #8f8f8f;background:#f5f5f5;color:#666;margin-bottom:10px;}
        	.faiButton:hover{border:1px solid #3298fe;background:#e8f3fe;color:#666;}
        	
        	.val-name{width:180px;height:26px;margin:2px 10px;}
        	.val-del{text-align:center}
        	.val-tr-bg1{background:#F8FAFD;}
        	.val-tr-bg2{background:#ffffff;}
        	
        	.jz_upload { box-sizing:border-box;width:78px;height:78px;border:1px dashed #ccc;line-height:76px;color:#666;cursor:pointer;text-align:center;overflow:hidden; }
        	.jz_upload_icon { display:inline-block;width:32px;height:35px;vertical-align:middle;background: url(../img/coustom/component.png?v=201806151520) no-repeat -323px -33px; }
        	.jz_img { box-sizing: border-box;width:78px;height:78px;border:1px solid #e7e7eb;text-align:center;font-size:0;line-height:0; }
        	.jz_img_item { display:inline-block;width:auto;height:auto;max-width:100%;max-height:100%;vertical-align:middle; }
        	.jz_editor { width:78px;height:78px;display:none; }
        	.jz_editor_layer { display:none;position:absolute;width:100%;height:100%;border:1px solid #5874d8;left:0;top:0;box-sizing:border-box; }
        	.jz_editor_del { width: 14px;height:14px;position:absolute;right:-5px;top:-5px;background:url(../img/coustom/component.png?v=201806151520) no-repeat -435px 0;cursor:pointer; }
        	.jz_editor_update { width:23px;height:23px;position:absolute;right:0;bottom:0;background:url(../img/coustom/component.png?v=201806151520) no-repeat -684px -44px;cursor:pointer;background-color:#557ce1; }
        	
        	.type2{display:{% if !attrInfo['type'] or attrInfo['type']=='T1' %}none{% endif %};}
        	.radio-box{padding-left:0}
        	#photoPvw{ width:180px;height:120px; }
			#photo{ display:none; }
			.wo-btn{ width:70px;height:30px;line-height:30px;background:#dedede;border-radius:5px;text-align:center;cursor:pointer}
			#proList{ width:80%; height:280px; border:1px solid #e3e2e8; margin-top:10px;overflow:auto;}
			#proList li{position:relative;width:240px;}
			#proList img{ width:240px;height:160px;margin:10px;}
			.del-item{ width:20px;height:20px;border-radius:10px;position:absolute;right:-20px;top:0px;background:#f00;line-height:20px;text-align:center;color:#fff;cursor:pointer;}
        	
        	.choosePhotoImg{ width:180px;height:120px; }
			.choosePhotoIpt{ display:none; }
        </style>
    </head>
    <script>
		var choosePros = "{{cxInfo['proids']}}";
		var proList = Array();
		function win_open(url, width, height){
			height == null ? height=500 : height;
			width == null ?  width=600 : width;
			var myDate = new Date();
			window.open(url+'?proIds='+choosePros,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
		}
		
		function delPro(id){/*删除商品*/
			$('#pro-'+id).remove();
			var cp = choosePros.split(','); var cpn = Array();
			for (var i=0; i<cp.length; ++i){
				if (cp[i] != id){
					cpn.push(cp[i]);
				}
			}
			choosePros = cpn.join();
		}

        /*从服务加载选择商品*/
        function getPros(proIds){
        	choosePros = proIds;
        	$.post('../CutPriceSprites/getPros', {proIds:proIds}, function(data){
        		var datas = jQuery.parseJSON(data);
        		if (datas.status == 1){
        			var pros = datas.pros;
        			proList = pros; rePros();
        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        	});
        }
        function rePros(){
        	var pros = proList;
        	var keys = Object.keys(pros);
			if (keys.length){
				$('#proList').html('');
				var sstyle = $("input[name='sstyle']:checked").val();
				for(var i in pros){
					var imgurl = sstyle=='S1' ? pros[i].photo_tj : pros[i].photo_tjx;
					var pl = $('<li id="pro-'+pros[i].id+'"></li>');
					var del = $('<div onclick="delPro('+pros[i].id+')" class="del-item">×</div>');
					var img = $('<img src="../files/uploadFiles/'+imgurl+'" />');
        			pl.append(img);pl.append(del);
					$('#proList').append(pl);
				}
			}
        }
        getPros("{{cxInfo['proids']}}");

	</script>
    <body style="min-height:auto">
    	<article class="page-container">
        	<form id="proCxForm" class="form form-horizontal" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>选项名称：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="选项名称" name="name" id="name" value="{{cxInfo['name']}}">
                    </div>
                </div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>引导图：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<img onclick="cppvw('photo','photoPvw');" id="photoPvw" src="{% if cxInfo['photo'] %}../files/uploadFiles/{{cxInfo['photo']}}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" >
						<input id="photo" name="photo" htp="{% if cxInfo['photo'] %}1{% else %}0{% endif %}" class="choosePhotoIpt" accept="image/*" type="file" />
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>广告图：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<img onclick="cppvw('adphoto','photoadPvw');" id="photoadPvw" src="{% if cxInfo['adphoto'] %}../files/uploadFiles/{{cxInfo['adphoto']}}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" >
						<input id="adphoto" name="adphoto" htp="{% if cxInfo['adphoto'] %}1{% else %}0{% endif %}" class="choosePhotoIpt" accept="image/*" type="file" />
					</div>
				</div>
					<label class="form-label col-xs-4 col-sm-3">主区配置：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="hui-form-radios" style="line-height:38px;">
					        <input type="radio" value="S1" name="sstyle" class="sstyle" id="sst1" onChange="rePros()" {% if cxInfo['sstyle']=='S1' %}checked="checked"{% endif %} /><label for="sst1">单列布局</label>
					        <input type="radio" value="S2" name="sstyle" class="sstyle" id="sst2" onChange="rePros()" {% if cxInfo['sstyle']=='S2' %}checked="checked"{% endif %} /><label for="sst2">双列布局</label>
					    </div>
					</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商品：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="wo-btn" onclick="win_open('../Product/chooseProPage',670,580);">选择商品</div>
						<ul id="proList"></ul>
					</div>
				</div>
                
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="button" onClick="subProCx()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        <input type="hidden" name="id" id='id' value="{{cxInfo['id']}}">
                    </div>
                </div>
            </form>
        </article>
        <script>
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
	    	
	    	function subProCx(){
	    		var name = $('#name');
	    		var sstyle = $("input[name='sstyle']:checked").val();
	    		
	    		if (!name){ layer.msg('请填写选项名称!', {  }); return false; }
	    		else if (!choosePros) { layer.msg('请填先选择商品!', {  }); return false; }
	    		else if (!$('#photo').val() && $('#photo').attr('htp')=='0') { layer.msg('请填先选择图片!', {  }); return false; }
	    		else if (!sstyle) { layer.msg('请填先选择布局方式!', {  }); return false; }
	    		var uploadFormData = new FormData($('#proCxForm')[0]);
	    		uploadFormData.append('proids', choosePros);
	    		$.ajax({
        	        url:'../product/saveProCx',
        	        type:"POST",
        	        contentType: false,
                    processData: false,
        	        data:uploadFormData,
        	        success: function(data) {
        	        	data = JSON.parse(data);
        	        	if (data.status == 1){
	        				layer.msg('操作成功!', { icon: 6, time: 1000 });
	        			}else {
	        				layer.msg(data.err, { icon: 5, time: 1000 });
	        			}
        	        }
        	    });
	    	}
    	</script>
    </body>

</html>