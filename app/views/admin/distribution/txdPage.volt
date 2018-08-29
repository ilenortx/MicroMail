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
        <title>产品列表</title>
    </head>
    <body style="min-height:auto">
        <nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>分销商管理<span class="c-gray en">&gt;</span><a href="../Distribution/withdrawDeposit">分销提现</a> <span class="c-gray en">&gt;</span> 提现信息<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
		<div class="page-container">
			{% if !msid or !txInfo %}
			数据错误!
			{% else %}
			<form class="form form-horizontal" method="post" onsubmit="return ac_from();" enctype="multipart/form-data">
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">分销商：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		            	{{txInfo['fxs']['name']}}
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">联系电话：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		            	{{txInfo['fxs']['phone']}}
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">所提时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                {{txInfo['year']}}-{{txInfo['month']}}
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">提现金额：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                {{txInfo['amount']}} 元
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">生成时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                {{txInfo['addtime']}}
		            </div>
		        </div>
		
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">申请时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                {{txInfo['sqtxtime']}}
		            </div>
		        </div>
		        
		        {% if txInfo['status']=='S3' %}
		        <div class="row cl">
		            <label class="form-label col-xs-4 col-sm-3">提现时间：</label>
		            <div class="formControls col-xs-8 col-sm-3">
		                {{txInfo['txtime']}}
		            </div>
		        </div>
		        {% endif %}
				
				{% if txInfo['status']!='S3' and txInfo['status']!='S0' %}
		        <div class="row cl">
		            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
		                <input class="btn btn-primary radius" type="button" name="tx" value="&nbsp;&nbsp;提现&nbsp;&nbsp;" id="txbtn">
		                <input class="btn radius" type="button" name="jtx" value="&nbsp;&nbsp;拒提&nbsp;&nbsp;" id="jtxbtn" style="color:#fff;background:#f00;border-color:#f00">
		                {% if msid %}<input type="hidden" name="id" id='msid' value="{{ msid }}">{% endif %}
		            </div>
		        </div>
		        {% endif %}
		    </form>
			{% endif %}
        </div>
        <!--_footer 作为公共模版分离出去-->
        {{ assets.outputJs('js1') }}
        <!--/_footer 作为公共模版分离出去-->
        <!--请在下方写此页面业务相关的脚本-->
        {{ assets.outputJs('js2') }}
        <script>
	        $('#txbtn').click(function(){
	        	var msid = $('#msid').val();
	        	$.post('../Distribution/dotx', {msid:msid, type:'T0'}, function(data){
	        		var datas = jQuery.parseJSON(data);
                	if (datas.status == 1){
                        layer.msg('操作成功!', { icon: 6, time: 1000 });
                        window.location.href='../Distribution/withdrawDeposit';
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	        	});
	        });
			$('#jtxbtn').click(function(){
	        	var msid = $('#msid').val();
				$.post('../Distribution/dotx', {msid:msid, type:'T1'}, function(data){
					var datas = jQuery.parseJSON(data);
                	if (datas.status == 1){
                        layer.msg('操作成功!', { icon: 6, time: 1000 });
                        window.location.href='../Distribution/withdrawDeposit';
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
	        	});
	        });
        </script>
    </body>
</html>