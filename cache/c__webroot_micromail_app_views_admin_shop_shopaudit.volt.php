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
        <title>店铺管理</title>
    </head>
    <script>
	    function textarealength(obj, len){
			if ($(obj).val().length > len) {
				$(obj).val($(obj).val().substring(0, len));
				return false;
			}
			$('.textarea-length').html($(obj).val().length);
		}
    </script>
    <body>
        <div class="page-container">
            <form action="" method="post" class="form form-horizontal" id="shop_audit">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">会员名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['hyinfo'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">负责人：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['uname'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">店铺名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['shop_name'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">联系电话：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['utel'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">地址：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['address'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">详细地址：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['address_xq'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">客服电话：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['kftel'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">申请时间：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['addtime'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">最新提交时间：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['sqtime'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">销售类型：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?= $sai['sale_type'] ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">审核状态：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?php if ($sai['status'] == 'S0') { ?>待审核
						<?php } elseif ($sai['status'] == 'S1') { ?> 审核中 
						<?php } elseif ($sai['status'] == 'S2') { ?> 审核通过
						<?php } elseif ($sai['status'] == 'S3') { ?> 审核未通过<?php } ?>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>审核状态：</label>
					<div class="formControls col-xs-8 col-sm-9 skin-minimal">
						<div class="radio-box">
							<input name="status" type="radio" id="status3" value="S3" checked>
							<label for="status3">不通过</label>
						</div>
						<div class="radio-box">
							<input type="radio" id="status2" value="S2" name="status">
							<label for="status2">通过</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">备注：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<textarea id="info" name="beizhu" cols="" rows="" class="textarea"  placeholder="说点什么..." onKeyUp="textarealength(this,100)"></textarea>
						<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
					</div>
				</div>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input id="submit" class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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
	        $(function(){
		        $('.skin-minimal input').iCheck({
		    		checkboxClass: 'icheckbox-blue',
		    		radioClass: 'iradio-blue',
		    		increaseArea: '20%'
		    	});
		    	
		        $("#submit").click(function(){
		        	var status = $("input[name='status']:checked").val();
		        	var info = $('#info').val();
		        	var id = <?= $sai['id'] ?>;
		        	
		        	if (!status || !info) alert('请正确审核');
		        	else {
		        		$.post('../ShopManagement/subAudit', {id:id, status:status, info:info}, function(data){
		        			data = JSON.parse(data);
		        			if (data.status == 1){
		        				layer.msg('操作成功!', { icon: 6, time: 1000 });
		        				var index = parent.layer.getFrameIndex(window.name);
		        				parent.layer.close(index);
		        			}else {
		        				layer.msg(data.msg, { icon: 6, time: 1000 });
		        			}
		        		});
		        	}
		        });
		    });
        </script>
    </body>
</html>