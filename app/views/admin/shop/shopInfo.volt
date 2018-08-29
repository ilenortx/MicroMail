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
    </head>
    <body style="min-height:auto">
    	<nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>店铺管理
	            <span class="c-gray en">&gt;</span>店铺信息
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
            <form id="shopInfo" class="form form-horizontal" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>店铺LOGO，图片大小230*230
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                    	{% if sinfo['logo'] %}
		                <img src="../files/uploadFiles/{{ sinfo['logo'] }}" width="80" height="80" style="margin-bottom: 3px;" />
		                <br />
		                {% endif %}
                    	<input type="file" name="logo" id="logo" />
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>店铺名称：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="店铺名称" name="name" id="name" value="{{ sinfo['name'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>负责人：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="负责人" name="uname" id="uname" value="{{ sinfo['uname'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>广告图，图片大小480*200
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                    	{% if sinfo['logo'] %}
		                <img src="../files/uploadFiles/{{ sinfo['vip_char'] }}" width="192" height="80" style="margin-bottom: 3px;" />
		                <br />
		                {% endif %}
                    	<input type="file" name="vip_char" id="vip_char" />
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>地址：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="地址，用英文逗号隔开" name="address" id=""address"" value="{{ sinfo['address'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>详细地址：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="详细地址" name="address_xq" id="address_xq" value="{{ sinfo['address_xq'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						创建日期：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        {{ sinfo['addtime'] }}
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>店铺广告语：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="店铺广告语" name="intro" id="intro" value="{{ sinfo['intro'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						等级评分：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        {{ sinfo['grade'] }}
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						负责人电话：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        {{ sinfo['utel'] }}
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>客服电话：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="客服电话" name="tel" id="tel" value="{{ sinfo['tel'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>分销提成：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="分销提成" name="fxtc" id="fxtc" value="{{ sinfo['fxtc'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        QQ号：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="QQ号" name="qq" id="qq" value="{{ sinfo['qq'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						微信APPID：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="微信APPID" name="wx_appid" id="wx_appid" value="{{ sinfo['wx_appid'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						微信MCH_ID：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="微信MCH_ID" name="wx_mch_id" id="wx_mch_id" value="{{ sinfo['wx_mch_id'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						微信KEY：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="微信KEY" name="wx_key" id="wx_key" value="{{ sinfo['wx_key'] }}">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
						微信SECRET：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="微信SECRET" name="wx_secret" id="wx_secret" value="{{ sinfo['wx_secret'] }}">
                    </div>
                </div>
                
                
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
		                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        <input type="hidden" name="id" id='id' value="{{ sinfo['id'] }}">
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
	        $(function(){
				/* 表单验证 */
		    	$("#shopInfo").validate({
		    		rules:{
		    			name:{required:true},
		    			uname:{required:true},
		    			address:{required:true},
		    			address_xq:{required:true},
		    			intro:{required:true},
		    			tel:{required:true},
		    			fxtc:{required:true}
		    		},
		    		onkeyup:false,
		    		focusCleanup:true,
		    		success:"valid",
		    		submitHandler:function(form){
		    			var uploadFormData = new FormData($('#shopInfo')[0]);
		    			$.ajax({
		        	        url:'../ShopManagement/saveShop',
		        	        type:"POST",
		        	        contentType: false,
		                    processData: false,
		        	        data:uploadFormData,
		        	        success: function(data) {
		        	        	data = JSON.parse(data);
		        	        	if (data.status == 1){
			        				layer.msg('操作成功!', { icon: 6, time: 1000 });
			        			}else {
			        				layer.msg(data.msg, { icon: 5, time: 1000 });
			        			}
		        	        }
		        	    });
		    		}
		    	});
		    });
        </script>
    </body>
</html>