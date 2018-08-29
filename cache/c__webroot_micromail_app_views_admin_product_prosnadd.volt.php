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
        
        <?= $this->assets->outputCss() ?>
        <?= $this->assets->outputJs() ?>
        
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
        	
        </style>
    </head>
    <script>
		
	</script>
    <body style="min-height:auto">
    	<article class="page-container">
        	<form id="prosnForm" class="form form-horizontal" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-2 col-sm-3">
                        <span class="c-red">*</span>标题：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="标题" name="title" id="title" value="<?= $sninfo['title'] ?>">
                    </div>
                </div>
				<div class="row cl">
                    <label class="form-label col-xs-2 col-sm-3">
                        <span class="c-red">*</span>内容：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="内容" name="descript" id="descript" value="<?= $sninfo['descript'] ?>">
                    </div>
                </div>
				<div class="row cl">
                    <label class="form-label col-xs-2 col-sm-3">排序：</label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="排序" name="sort" id="sort" value="<?= $sninfo['sort'] ?>">
                    </div>
                </div>
				
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="button" onClick="subProsn()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        <input type="hidden" name="id" id='id' value="<?= $sninfo['id'] ?>">
                    </div>
                </div>
            </form>
        </article>
        <script>
	    	function subProsn(){
	    		var title = $('#title');
	    		var descript = $('#descript');
	    		
	    		if (!title){ layer.msg('请填写标题!', {  }); return false; }
	    		else if (!descript) { layer.msg('请填写内容!', {  }); return false; }
	    		
	    		var uploadFormData = new FormData($('#prosnForm')[0]);
	    		$.ajax({
        	        url:'../product/saveProsn',
        	        type:"POST",
        	        contentType: false,
                    processData: false,
        	        data:uploadFormData,
        	        success: function(data) {
        	        	data = JSON.parse(data);
        	        	if (data.status == 1){
	        				layer.msg('操作成功!', { icon: 6, time: 1000 });
	        				window.parent.reloadData();
	        				layer_close();
	        			}else {
	        				layer.msg(data.err, { icon: 5, time: 1000 });
	        			}
        	        }
        	    });
	    	}
    	</script>
    </body>

</html>