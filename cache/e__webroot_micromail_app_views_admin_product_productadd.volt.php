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
        
        <?= $this->assets->outputCss('css1') ?>
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        <?= $this->assets->outputCss('css2') ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        
        <?= $this->assets->outputJs() ?>
        
        <style>
            .inp_2 {width: 770px;height: 300px;} .inp_1 {border-radius: 2px;border: 1px solid #b9c9d6;float: left;} li {list-style-type:none;} .dx1{float:left; margin-left: 17px; margin-bottom:10px; } .dx2{color:#090; font-size:16px; border-bottom:1px solid #CCC; width:100% !important; padding-bottom:8px;} .dx3{width:120px; margin:5px auto; border-radius: 2px; border: 1px solid #b9c9d6; display:block;} .dx4{border-bottom:1px solid #eee; padding-top:5px; width:100%;} .img-err { position: relative; top: 2px; left: 82%; color: white; font-size: 20px; border-radius: 16px; background: #c00; height: 21px; width: 21px; text-align: center; line-height: 20px; cursor:pointer; } .btnp{ height: 25px; width: 60px; line-height: 24px; padding: 0 8px; background: #24a49f; border: 1px #26bbdb solid; border-radius: 3px; color: #fff; display: inline-block; text-decoration: none; font-size: 13px; outline: none; -webkit-box-shadow: #666 0px 0px 6px; -moz-box-shadow: #666 0px 0px 6px; } .btnp:hover{ border: 1px #0080FF solid; background:#D2E9FF; color: red; -webkit-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; -moz-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; } .cls{ background: #24a49f; }
        </style>
        <title>添加产品</title>
    </head>
    
    <body>
    	<nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i>首页
            <span class="c-gray en">&gt;</span>产品管理
            <?php if ($pid) { ?>
            <span class="c-gray en">&gt;</span><a href="../Product/plPage">全部产品</a>
            <span class="c-gray en">&gt;</span>产品编辑
            <?php } else { ?>
            <span class="c-gray en">&gt;</span>添加产品
            <?php } ?>
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <div class="page-container">
            <form class="form form-horizontal" action="../Product/addProduct" onsubmit="return ac_from();" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>产品名称：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="产品名称" name="name" id="name" value="<?= $proInfo['name'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>广告语：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="广告语" name="intro" id="intro" value="<?= $proInfo['intro'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>选择分类：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <select class="inp_1" name="cateid" id="cateid" onchange="getcid();" style="width:150px;margin-right:5px;">
                            <option value="">一级分类</option>
                            <?php foreach ($list2 as $list) { ?>
                            <option value="<?= $list['id'] ?>" <?php if ($list['id'] == $proInfo['tid']) { ?>selected="selected"<?php } ?>>-- <?= $list['name'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <?php if ($catetwo) { ?>
                        <select class="inp_1" name="cid" id="cid" style="width:150px;">
		                    <option value="">二级分类</option>
		                    <?php foreach ($catetwo as $ct) { ?>
		                        <option value="<?= $ct['id'] ?>" <?php if ($ct['id'] == $proInfo['cid']) { ?>selected="selected"<?php } ?>>-- <?= $ct['name'] ?></option>
		                    <?php } ?>
		                </select>
                        <?php } else { ?>
                        <select class="inp_1" name="cid" id="cid" style="width:150px;">
                            <option value="">二级分类</option>
                        </select>
                        <?php } ?>
                        <span id="catedesc" style="color:red;font-size: 12px;">&nbsp;&nbsp; * 必选项</span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>选择品牌：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <select class="inp_1" name="brand_id" id="brand_id" style="width:150px;margin-right:5px;">
                            <option value="">选择品牌</option>
                            <?php foreach ($brand as $b) { ?>
                                <option value="<?= $b['id'] ?>" <?php if ($b['id'] == $proInfo['brand_id']) { ?>selected="selected"<?php } ?>>-- <?= $b['name'] ?></option>
                           	<?php } ?>
                       	</select>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>单 位：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="单 位" name="company" id="company" value="<?= $proInfo['company'] ?>">
                        <span style="color:red;font-size: 12px;">&nbsp;&nbsp;举例:个/只/件&nbsp;&nbsp;请根据产品来自行添加相应单位</span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>原 价：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="原 价" name="price" id="price" value="<?= $proInfo['price'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>优惠价：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="优惠价" name="price_yh" id="price_yh" value="<?= $proInfo['price_yh'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>赠送积分：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="赠送积分" name="price_jf" id="price_jf" value="<?= $proInfo['price_jf'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>产品编号：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="产品编号" name="pro_number" id="pro_number" value="<?= $proInfo['pro_number'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>库存：
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="库存" name="num" id="num" value="<?= $proInfo['num'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>缩略图，图片大小230*230
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                    	<?php if ($proInfo['photo_x']) { ?>
		                <img src="../files/uploadFiles/<?= $proInfo['photo_x'] ?>" width="80" height="80" style="margin-bottom: 3px;" />
		                <br />
		                <?php } ?>
                    	<input type="file" name="photo_x" id="photo_x" />
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>大 图，图片大小600*600
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
	                    <?php if ($proInfo['photo_d']) { ?>
		                <img src="../files/uploadFiles/<?= $proInfo['photo_d'] ?>" width="125" height="125" style="margin-bottom: 3px;" />
		                <br />
		                <?php } ?>
                        <input type="file" name="photo_d" id="photo_d" />
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>上传产品详情轮播图: 600*600的图片
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
		                <?php if ($proInfo['photo_string']) { ?>
		                <li>
		                    <div class="d1">已上传：</div>
		                    <?php foreach ($proInfo['photo_string'] as $ps) { ?>
		                    <div>
		                        <div class="img-err" title="删除" onclick="del_img('<?= $ps ?>',this);">×</div>
		                        <img src="../files/uploadFiles/<?= $ps ?>" width="125" height="125">
		                    </div>
		                    <?php } ?>
		                </li>
		                <?php } ?>
                        <li id="imgs_add">
                        	<div class="d1" style="ont-family: '微软雅黑',Arial,Helvetica,sans-serif;color: #063559;">轮播图:</div>
                        	<div>
                         		<input type="file" name="files[]" style="width:160px;" />
                         	</div>
                     	</li>
                      	<li>
                      		<div class="d1">&nbsp;</div>
                          	<div>&nbsp;
                             	<span class="btnp cls" style="background:#D0D0D0; width:40px; color:black;" onclick="upadd();">添加</span>
                            </div>
                     	</li>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>产品介绍：
                    </label>
                    <div class="">
                        <textarea class="inp_1 inp_2" name="content" id="content" /><?= $proInfo['content'] ?></textarea>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>人气：</label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="text" class="input-text" placeholder="人气" name="renqi" id="renqi" value="<?= $proInfo['renqi'] ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>新上市：</label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="radio" name="is_show" value="1" <?php if ($proInfo['is_show'] == 1) { ?> checked="checked" <?php } ?> /> 是 &nbsp;
                        <input type="radio" name="is_show" value="0" <?php if ($proInfo['is_show'] == 0) { ?> checked="checked" <?php } ?> /> 否
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>热销产品：</label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="radio" name="is_hot" value="1" <?php if ($proInfo['is_hot'] == 1) { ?> checked="checked" <?php } ?> /> 是 &nbsp;
                        <input type="radio" name="is_hot" value="0" <?php if ($proInfo['is_hot'] == 0) { ?> checked="checked" <?php } ?> /> 否</div>
                    </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>品牌图片，图片大小120*120
                    </label>
                    <div class="formControls col-xs-8 col-sm-3">
                        <input type="file" name="file" id="file" value="">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        <?php if ($proInfo['id']) { ?><input type="hidden" name="pro_id" id='pro_id' value="<?= $proInfo['id'] ?>"><?php } ?>
                    </div>
                </div>
            </form>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <script>
        	/*初始化编辑器*/
            $('#content').xheditor({
                skin: 'nostyle',
                upImgUrl: '../Upload/xheditor'
            });

            function upadd(obj) {
                $('#imgs_add').append('<div>&nbsp;&nbsp;<input type="file" style="width:160px;" name="files[]" /><a onclick="$(this).parent().remove();" class="btn cls" style="background:#D0D0D0; width:40px; color:black;"">删除</a></div>');
                return false;
            }

            function getcid() {
            	var jsonData = JSON.parse('<?= $list3 ?>');
            	
            	var jsonArr = Array();
            	for(var key in jsonData){
            		jsonArr[key] = jsonData[key];
            	}
            	
                var cateid = $('#cateid').val();
                var option = jsonArr[cateid];
                if (option.length > 0) {
                    var htmls = '<option value="">二级分类</option>';
                    for (var i = 0; i < option.length; i++) {
                        htmls += '<option value="' + option[i]['id'] + '">-- ' + option[i]['name'] + '</option>';
                    }
                    $('#cid').html(htmls);
                    $('#catedesc').html('&nbsp;&nbsp; * 必选项');
                } else {
                    $('#cid').html('<option value="">二级分类</option>');
                    $('#catedesc').html('&nbsp;&nbsp; * 该分类下还没有二级分类，请先添加');
                }
            }

            /* 图片删除 */
            function del_img(img, obj) {
                var pro_id = $('#pro_id').val();
                layer.confirm('确认要删除吗？',function(index) {
               		$.post('../Product/delImg', {img_url:img, pro_id:pro_id}, function(data){
                   		var datas = jQuery.parseJSON(data);
                      	if (datas.status == 1){
                      		 $(obj).parent().remove();
                         	layer.msg('已删除!', { icon: 1,time: 1000 });
                      	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
               		});
             	});
            }

            function ac_from() {

                var name = document.getElementById('name').value;
                if (name.length < 1) {
                    alert('产品名称不能为空');
                    return false;
                }

                var cid = parseInt(document.getElementById("cid").value);
                if (!cid) {
                    alert("请选择分类.");
                    return false;
                }

            }</script>
    </body>

</html>