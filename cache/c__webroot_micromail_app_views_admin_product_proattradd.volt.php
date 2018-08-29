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
        	
        	.type2{display:<?php if (!$attrInfo['type'] || $attrInfo['type'] == 'T1') { ?>none<?php } ?>;}
        	.radio-box{padding-left:0}
        </style>
    </head>
    
    <body style="min-height:auto">
    	<article class="page-container">
        	<form class="form form-horizontal" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>选项名称：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="选项名称" name="name" id="name" value="<?= $attrInfo['name'] ?>">
                    </div>
                </div>
                
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-3">使用模式：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="radio-box">
						    <input type="radio" class="type" name="type" value="T1" <?php if ($attrInfo['type'] == 'T1') { ?> checked="checked" <?php } ?>>
						    <label for="radio-1">全部产品</label>
						</div>
						<div class="radio-box" style="margin-left:20px">
						    <input type="radio" class="type" value="T2" name="type" <?php if ($attrInfo['type'] == 'T2') { ?> checked="checked" <?php } ?>>
						    <label for="radio-2">单个产品</label>
						</div>
					</div>
				</div>
				<div class="type2" class="row cl">
					<label class="form-label col-xs-4 col-sm-3">商品：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<div class="jz_upload pd_choose jz_upload_normal" onclick="win_open('../ProductAttr/chooseProPage',670,580)"><div class="jz_upload_icon"></div></div>
						<div class="jz_editor img_editor">
							<div class="jz_img">
								<img src="" class="jz_img_item">
							</div>
							<div class="jz_editor_layer">
								<i class="jz_editor_item jz_editor_del"></i>
								<i class="jz_editor_item jz_editor_update" onclick="win_open('../ProductAttr/chooseProPage',670,580)"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="type2" class="row cl">
					<label class="form-label col-xs-4 col-sm-3">商品名称：</label>
					<div class="formControls col-xs-8 col-sm-9" style='height:30px'>
						<div id="pro_name"></div>
					</div>
				</div>
				
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>排序：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="number" class="input-text" name="sort" id="sort" value="<?= $attrInfo['sort'] ?>">
                    </div>
                </div>
                <div class="row cl">
                	<label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>选项值：
                    </label>
                    <div class="formControls col-xs-8">
                    	<input class="addItemBtn faiButton" type="button" value="添加值" onclick="addValItem()">
                    	<table class="val-table val-table-title">
                    		<tr>
                    			<th width="240px">选项值</th>
                    			<th width="160px">操作</th>
                    		</tr>
                    	</table>
                    	<div class='values'>
                    		<table id="val-tab" class='val-table var-values-table'>
                    			<?php $item = 0; ?>
                    			<?php foreach ($attrInfo['values'] as $val) { ?>
			                    <tr class='val-tr <?php if ($item % 2) { ?>val-tr-bg2<?php } else { ?>val-tr-bg1<?php } ?>'>
			                    	<td width="240px"><input class="input-text val-name" data-id="<?= $val['id'] ?>" value="<?= $val['name'] ?>" type="text" /></td>
			                    	<td class="val-del" width="160px"><a onClick="delValItem(this, <?= $val['id'] ?>, <?= $attrInfo['id'] ?>)">删除</a></td>
			                    </tr>
			                    <?php $item += 1; ?>
			                    <?php } ?>
			                </table>
                    	</div>
	                	
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="button" onClick="dataSub()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        <input type="hidden" name="id" id='id' value="<?= $attrInfo['id'] ?>">
                    </div>
                </div>
            </form>
        </article>
        <!--_footer 作为公共模版分离出去-->
        <script>
			var choosePro = <?= $attrInfo['pro_id'] ?>;
        	var addItemNum = 1;
        	var delItems = Array();
        	function addValItem(){
        		var valtr = $('.val-tr');
        		var valbg = valtr.length%2 ? 'val-tr-bg2' : 'val-tr-bg1';
        		addItemNum = valtr.length+1;
        		var tr = $('<tr class="val-tr '+valbg+'"></tr>');
        		var td = $('<td width="240px"><input class="input-text val-name" data-id="0" type="text" value="选项'+addItemNum+'" /></td><td class="val-del" width="160px"><a onClick="delValItem(this, 0, 0)">删除</a></td>');
        		tr.append(td);
        		$('#val-tab').append(tr);
        	}
        	
        	function delValItem(obj, vid, pvid){
        		$(obj).parents("tr").remove();
        		if (vid) delItems.push({id:vid, pid:pvid});
        	}
        	
        	function dataSub(){
        		var id = $('#id').val();
        		var name = $('#name').val();
        		var sort = $('#sort').val();
        		var type = $("input[name='type']:checked").val();
        		var vals = Array();
        		
        		var valname = $('.val-name');
        		
        		for(var i=0; i<valname.length; ++i){
        			/*vals += $(valname[i]).val()+',';*/
        			vals.push({id:$(valname[i]).attr('data-id'), name:$(valname[i]).val(), pname:name});
        		}
        		
        		if (!name || !vals.length) { layer.msg('请完整填写数据!', function(){ }); return; }
        		vals = JSON.stringify(vals);
        		delItems = JSON.stringify(delItems);
        		$.post('../ProductAttr/saveProAttr', {id:id, name:name, sort:sort, type:type, pro_id:choosePro, vals:vals, delItems:delItems}, function(data){
        			var datas = jQuery.parseJSON(data);
                  	if (datas.status == 1){
                  		layer.msg('成功!', { icon: 6,time: 1000 });
                  		layer_close();
                  	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        		});
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
	        if (choosePro) getPros(choosePro);
    		function win_open(url, width, height){
    			height == null ? height=500 : height;
    			width == null ?  width=600 : width;
    			var myDate = new Date();
    			window.open(url+'?proId='+choosePro,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
    		}
    		
    		$(".type").change(function() {
    			var sv = $("input[name='type']:checked").val(); 
    			if (sv == 'T1') { 
    				$('.type2').hide();
    			}else { 
    				$('.type2').show();
    			} 
    		});
    	</script>
    </body>

</html>