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
    
    <body style="min-height:auto">
        <nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>疑难问题
	            <span class="c-gray en">&gt;</span><a href="../ServiceCenter/index">管理问题</a>
	            <span class="c-gray en">&gt;</span>编辑问题
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
        	<form class="form form-horizontal" style="width:400px;margin:auto;">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="<?= $scInfo['name'] ?>" placeholder="名称" id="name" name="name">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">描述：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<textarea name="content" id="content" class="textarea"  placeholder="" dragonfly="true"><?= $scInfo['content'] ?></textarea>
					</div>
				</div>
				<?php if ($scInfo['id']) { ?>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">状态：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<?php if ($scInfo['status'] == 'S1') { ?>
			              	<label style="color:green;">正常</label>
			            <?php } else { ?>
			              	<label style="color:red;">停用</label>
			          	<?php } ?>
					</div>
				</div>
				<?php } ?>
				<div class="row cl">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
						<input class="btn btn-primary radius" id="submit" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
						<input type="hidden" id='id' value="<?= ($scInfo['id'] ? $scInfo['id'] : 0) ?>">
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
            $('#submit').click(function(){
            	var name = $('#name').val();
            	var content = $('#content').val();
            	var id = $('#id').val();
            	
            	$.post('../ServiceCenter/saveSc', {'id':id, 'name':name, 'content':content}, function(data){
                	var datas = jQuery.parseJSON(data);
                	if (datas.status == 1){
                		/*$('#id').val(datas.id);*/
                        /*layer.msg('操作成功!', { icon: 6, time: 1000 });
                		javascript:location.replace(location.href);*/
                		layer.alert('操作成功!', {icon: 6}, function(){
                			javascript:location.replace(location.href);
                		});
                	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                });
            });
        </script>
    </body>
</html>