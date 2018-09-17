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

        {{ assets.outputCss('css1') }}
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        {{ assets.outputCss('css2') }}

        <!--[if IE 6]>
            <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->

        {{ assets.outputJs() }}

        <style>
            body,.page-container{height: calc(100% - 40px);}
            .layui-tab-title li{float:none;}
            .layui-tab-brief{height: calc(100% - 40px);}
            .layui-tab-content{height: calc(100% - 51px);overflow-y: auto;overflow-x:hidden;}
            .form-horizontal{height: 100%;}

            .inp_2 {width: 770px;height: 300px;} .inp_1 {border-radius: 2px;border: 1px solid #b9c9d6;float: left;} li {list-style-type:none;} .dx1{float:left; margin-left: 17px; margin-bottom:10px; } .dx2{color:#090; font-size:16px; border-bottom:1px solid #CCC; width:100% !important; padding-bottom:8px;} .dx3{width:120px; margin:5px auto; border-radius: 2px; border: 1px solid #b9c9d6; display:block;} .dx4{border-bottom:1px solid #eee; padding-top:5px; width:100%;} .img-err { position: relative; top: 2px; left: 82%; color: white; font-size: 20px; border-radius: 16px; background: #c00; height: 21px; width: 21px; text-align: center; line-height: 20px; cursor:pointer; } .btnp{ height: 25px; width: 60px; line-height: 24px; padding: 0 8px; background: #24a49f; border: 1px #26bbdb solid; border-radius: 3px; color: #fff; display: inline-block; text-decoration: none; font-size: 13px; outline: none; -webkit-box-shadow: #666 0px 0px 6px; -moz-box-shadow: #666 0px 0px 6px; } .btnp:hover{ border: 1px #0080FF solid; background:#D2E9FF; color: red; -webkit-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; -moz-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px; } .cls{ background: #24a49f; }
        	#intro_editor{ overflow:auto;height:50px; }
        	.choosePhotoImg{ width:180px;height:120px; }
			.choosePhotoIpt{ display:none; }
			.wo-btn{ width:70px;height:30px;line-height:30px;background:#dedede;border-radius:5px;text-align:center;cursor:pointer}
			#proList{ width:80%; height:150px; border:1px solid #e3e2e8; margin-top:10px;overflow:auto;}
			#proList li{position:relative;width:80px;height:80px;float:left;}
			#proList img{ width:80px;height:80px;margin:10px;}
			.del-item{ width:20px;height:20px;border-radius:10px;position:absolute;right:-20px;top:0px;background:#f00;line-height:20px;text-align:center;color:#fff;cursor:pointer;}
        </style>
        <title>添加产品</title>
    </head>
    <script>
		var choosePros = "{{proInfo['tjpro']}}";
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
        			$('#proList').html('');
        			var pros = datas.pros;
        			var keys = Object.keys(pros);
        			if (keys.length){
        				for(var i in pros){
        					var pl = $('<li id="pro-'+pros[i].id+'"></li>');
        					var del = $('<div onclick="delPro('+pros[i].id+')" class="del-item">×</div>');
        					var img = $('<img src="../files/uploadFiles/'+pros[i].photo_x+'" />');
                			pl.append(img);pl.append(del);
        					$('#proList').append(pl);
        				}
        			}
        		}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        	});
        }
        getPros("{{proInfo['tjpro']}}");

	</script>
    <body style="min-height:auto">
    	<nav class="navb">
        	<div class="breadcrumb">
	            <i class="Hui-iconfont">&#xe67f;</i>首页
	            <span class="c-gray en">&gt;</span>产品管理
	            {% if pid %}
	            <span class="c-gray en">&gt;</span><a href="../Product/plPage">全部产品</a>
	            <span class="c-gray en">&gt;</span>产品编辑
	            {% else %}
	            <span class="c-gray en">&gt;</span>添加产品
	            {% endif %}
	            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
	                <i class="Hui-iconfont">&#xe68f;</i>
	            </a>
	        </div>
        </nav>
        <div class="page-container">
            <form class="form form-horizontal" action="../Product/addProduct" onsubmit="return ac_from();" enctype="multipart/form-data" method="post">
                <div class="layui-tab layui-tab-brief">
                    <ul class="layui-tab-title">
                        <li class="layui-this">基本信息</li>
                        <li>展示图片与视频</li>
                        <li>商品轮播图</li>
                        <li>产品介绍</li>
                        <li>标签与相关信息</li>
                        <li>商品属性</li>
                        <li>商品参数</li>
                    </ul>
                    <div class="layui-tab-content">
                        <!-- 基本信息 start -->
                        <div class="layui-tab-item layui-show">
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>产品名称：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="产品名称" name="name" id="name" value="{{ proInfo['name'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>广告语：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <div class="input-text" id="intro_editor"></div>
                                    <span id="makeLink" class="prompt"><i class="Hui-iconfont">&#xe6f1;</i></span>
                                    <input type="hidden" class="input-text" placeholder="广告语" name="intro" id="intro" value='{{ proInfo["intro"] }}'>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>选择分类：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <select class="inp_1" name="cateid" id="cateid" onchange="getcid();" style="width:150px;margin-right:5px;">
                                        <option value="">一级分类</option>
                                        {% for list in list2 %}
                                        <option value="{{ list['id'] }}" {% if list['id']==proInfo['tid'] %}selected="selected"{% endif %}>-- {{ list['name'] }}</option>
                                        {% endfor %}
                                    </select>
                                    <br>
                                    {% if catetwo %}
                                    <select class="inp_1" name="cid" id="cid" style="width:150px;">
                                        <option value="">二级分类</option>
                                        {% for ct in catetwo %}
                                            <option value="{{ ct['id'] }}" {% if ct['id']==proInfo['cid'] %}selected="selected"{% endif %}>-- {{ ct['name'] }}</option>
                                        {% endfor %}
                                    </select>
                                    {% else %}
                                    <select class="inp_1" name="cid" id="cid" style="width:150px;">
                                        <option value="">二级分类</option>
                                    </select>
                                    {% endif %}
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
                                        {% for b in brand %}
                                            <option value="{{ b['id'] }}" {% if b['id']==proInfo['brand_id'] %}selected="selected"{% endif %}>-- {{ b['name'] }}</option>
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>单 位：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="单 位" name="company" id="company" value="{{ proInfo['company'] }}">
                                    <span style="color:red;font-size: 12px;">&nbsp;&nbsp;举例:个/只/件&nbsp;&nbsp;请根据产品来自行添加相应单位</span>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>原 价：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="原 价" name="price" id="price" value="{{ proInfo['price'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>优惠价：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" onInput="getSetPrice(this);" placeholder="优惠价" name="price_yh" id="price_yh" value="{{ proInfo['price_yh'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>赠送积分：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="赠送积分" name="price_jf" id="price_jf" value="{{ proInfo['price_jf'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>产品编号：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="产品编号" name="pro_number" id="pro_number" value="{{ proInfo['pro_number'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>库存：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="库存" name="num" id="num" value="{{ proInfo['num'] }}">
                                </div>
                            </div>
                        </div>
                        <!-- 基本信息 end -->

                        <!-- 展示图片与视频 start -->
                        <div class="layui-tab-item">
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>缩略图，图片大小230*230
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <!-- {% if proInfo['photo_x'] %}
                                    <img src="../files/uploadFiles/{{ proInfo['photo_x'] }}" width="80" height="80" style="margin-bottom: 3px;" />
                                    <br />
                                    {% endif %}
                                    <input type="file" name="photo_x" id="photo_x" /> -->

                                    <img onclick="cppvw('photo_x','photoxPvw');" id="photoxPvw" src="{% if proInfo['photo_x'] %}../files/uploadFiles/{{ proInfo['photo_x'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:80px;height:80px"  >
                                    <input id="photo_x" class="choosePhotoIpt" name="photo_x" accept="image/*" type="file" />
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>大 图，图片大小600*600
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <!-- {% if proInfo['photo_d'] %}
                                    <img src="../files/uploadFiles/{{ proInfo['photo_d'] }}" width="125" height="125" style="margin-bottom: 3px;" />
                                    <br />
                                    {% endif %}
                                    <input type="file" name="photo_d" id="photo_d" /> -->

                                    <img onclick="cppvw('photo_d','photodPvw');" id="photodPvw" src="{% if proInfo['photo_d'] %}../files/uploadFiles/{{ proInfo['photo_d'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:125px;height:125px"  >
                                    <input id="photo_d" class="choosePhotoIpt" name="photo_d" accept="image/*" type="file" />
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>商品推荐小图100*100
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <img onclick="cppvw('photo_tjx','phototjxPvw');" id="phototjxPvw" src="{% if proInfo['photo_tjx'] %}../files/uploadFiles/{{ proInfo['photo_tjx'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:100px;height:100px"  >
                                    <input id="photo_tjx" class="choosePhotoIpt" name="photo_tjx" accept="image/*" type="file" />
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>商品推荐图3 : 2
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <img onclick="cppvw('photo_tj','phototjPvw');" id="phototjPvw" src="{% if proInfo['photo_tj'] %}../files/uploadFiles/{{ proInfo['photo_tj'] }}{% else %}../img/coustom/click.png{% endif %}" class="choosePhotoImg" style="margin-bottom: 3px;width:180px;height:120px"  >
                                    <input id="photo_tj" class="choosePhotoIpt" name="photo_tj" accept="image/*" type="file" />
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">小视频</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    {% if proInfo['video'] %}
                                    <div>
                                        <div class="img-err" title="删除" onclick="del_video('{{proInfo['video']}}',this);" style="left:100px">×</div>
                                        <img src="../img/coustom/video-icon.jpg" width="80" height="60">
                                    </div>
                                    {% endif %}
                                    <input type="file" name="video" style="width:160px;" />
                                </div>
                            </div>
                        </div>
                        <!-- 展示图片与视频 end -->

                        <!-- 商品轮播图 start -->
                        <div class="layui-tab-item">
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>上传产品详情轮播图: 600*600的图片
                                </label>
                                <div class="formControls col-xs-8 col-sm-3" style="width:70%;">
                                    {% if proInfo['photo_string'] %}
                                    <li style="max-height:300px;overflow:auto;">
                                        <div class="d1">已上传：</div>
                                        {% for ps in proInfo['photo_string'] %}
                                        <div style="width:150px;float:left;">
                                            <div class="img-err" title="删除" onclick="del_img('{{ ps }}',this);">×</div>
                                            <img src="../files/uploadFiles/{{ ps }}" width="125" height="125">
                                        </div>
                                        {% endfor %}
                                    </li>
                                    {% endif %}
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
                        </div>
                        <!-- 商品轮播图 end -->

                        <!-- 产品介绍 start -->
                        <div class="layui-tab-item">
                            <div class="cl">
                                <textarea class="inp_1 inp_2" style="width:100%;height:600px" name="content" id="content" />{{ proInfo['content'] }}</textarea>
                            </div>
                        </div>
                        <!-- 产品介绍 end -->

                        <!-- 标签与相关信息 start -->
                        <div class="layui-tab-item">
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>人气：</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="人气" name="renqi" id="renqi" value="{{ proInfo['renqi'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>排序：</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="text" class="input-text" placeholder="排序" name="sort" id="sort" value="{{ proInfo['sort'] }}">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>新上市：</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="radio" name="is_show" value="1" {% if proInfo['is_show']==1 %} checked="checked" {% endif %} /> 是 &nbsp;
                                    <input type="radio" name="is_show" value="0" {% if proInfo['is_show']==0 %} checked="checked" {% endif %} /> 否
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    <span class="c-red">*</span>热销产品：</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <input type="radio" name="is_hot" value="1" {% if proInfo['is_hot']==1 %} checked="checked" {% endif %} /> 是 &nbsp;
                                    <input type="radio" name="is_hot" value="0" {% if proInfo['is_hot']==0 %} checked="checked" {% endif %} /> 否</div>
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
                                <label class="form-label col-xs-4 col-sm-3">促销产品</label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    <!-- <img onclick="cppvw('cxphoto','cxphotoPvw');" id="cxphotoPvw" class="choosePhotoImg"  >
                                    <input id="cxphoto" class="choosePhotoIpt" name="cxphoto" accept="image/*" type="file" /> -->
                                    <select name="procxid" id="procxid" style="width:150px;margin-right:5px;">
                                        <option value="">请选择</option>
                                        {% for cx in cxlist %}
                                        <option value="{{ cx['id'] }}" {% if cx['id']==proInfo['procxid'] %}selected="selected"{% endif %}>{{ cx['name'] }}</option>
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">相关推荐：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <div class="wo-btn" onclick="win_open('../CutPriceSprites/chooseProPage',670,580);">选择商品</div>
                                    <ul id="proList"></ul>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">产品说明：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {% for sn in prosns %}
                                    <div class="check-box">
                                        <?php if(in_array($sn['id'], $proInfo['snids'])){?>
                                            <input type="checkbox" name="snids[]" id="checkbox-{{sn['id']}}" value="{{sn['id']}}" checked="checked">
                                        <?php }else{ ?>
                                            <input type="checkbox" name="snids[]" id="checkbox-{{sn['id']}}" value="{{sn['id']}}">
                                        <?php }?>
                                        <label for="checkbox-{{sn['id']}}">{{sn['title']}}</label>
                                    </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                        <!-- 标签与相关信息 end -->

                        <!-- 商品属性 start -->
                        <div class="layui-tab-item">
                            <div class="row cl">
                                <div class="formControls col-xs-8 col-sm-3" style="width:600px;">
                                    {% for attr in attrs %}
                                    <ul class="SKU_TYPE">
                                        <li is_required='0' propid='{{attr['id']}}' sku-type-name="{{attr['name']}}"><em>*</em>{{attr['name']}}：</li>
                                    </ul>
                                    <ul>
                                        {% for val in attr['values'] %}
                                        <li><label><input {% if val['checked']==1 %}checked="checked"{% endif %} type="checkbox" class="sku_value" propid="{{attr['id']}}" propvalid='{{val['id']}}' value="{{val['name']}}" />{{val['name']}}</label></li>
                                        {% endfor %}
                                    </ul>
                                    <div class="clear"></div>
                                    {% endfor %}

                                    <div id="skuTable"></div>
                                </div>
                            </div>
                        </div>
                        <!-- 商品属性 end -->

                        <!-- 商品属性 start -->
                        <div class="layui-tab-item">
                            {% for vk,p_item in parmData %}
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">
                                    {{p_item['name']}}：
                                </label>
                                <div class="formControls col-xs-8 col-sm-3">
                                    {% set parm_value = proInfo['parm'][p_item['id']] %}
                                    {% if p_item['type']=='text' %}
                                    <input type="text" class="input-text" name="parm[{{p_item['id']}}]" id="name" value="{{parm_value}}">
                                    {% else %}
                                    <select name="parm[{{p_item['id']}}]">
                                        <option value="">未选择</option>
                                        {% for k,option_item in p_item['value'] %}
                                        <option value="{{k}}" {% if parm_value==k %}selected="selected"{% endif %} >{{option_item}}</option>
                                        {% endfor %}
                                    </select>
                                    {% endif %}
                                </div>
                            </div>
                            {% endfor %}
                        </div>
                        <!-- 商品属性 end -->
                    </div>
                </div>

                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        {% if proInfo['id'] %}<input type="hidden" name="pro_id" id='pro_id' value="{{ proInfo['id'] }}">{% endif %}
                        <input type="hidden" name="sku" id="sku" />
                        <input type="hidden" name="proAttrs" id="proAttrs" />
                        <input type="hidden" name="tjpro" id="tjpro" />
                    </div>
                </div>
            </form>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <script>
	        $(document).ready(function(){
	        	getSetPrice($('#price_yh'));
	        	setAlreadySetSkuVals('{{skus}}');
	        	createSkuTable();

                layui.use('element', function(){
                    var $ = layui.jquery, element = layui.element;
                });
	        });

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
            	var jsonData = JSON.parse('{{ list3 }}');

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

            /* 小视频删除 */
            function del_video(video, obj) {
                var pro_id = $('#pro_id').val();
                layer.confirm('确认要删除吗？',function(index) {
               		$.post('../Product/delVideo', {video_url:video, pro_id:pro_id}, function(data){
                   		var datas = jQuery.parseJSON(data);
                      	if (datas.status == 1){
                      		 $(obj).parent().remove();
                         	layer.msg('已删除!', { icon: 1,time: 1000 });
                      	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
               		});
             	});
            }

            function ac_from() {
            	var skuvals = getSkuVals();
            	var proAttrs = getProAttrs();
            	if (!skuvals) return false;
            	$('#sku').val(JSON.stringify(skuvals));
            	$('#proAttrs').val(JSON.stringify(proAttrs));

				$('#intro').val($('#intro_editor .paragraph').html());
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
                $('#tjpro').val(choosePros);

            }

            var div = document.getElementById( 'intro_editor' );
            var editor = new Squire( div, {
                blockTag: 'p',
                blockAttributes: {'class': 'paragraph'},
                tagAttributes: {
                    ul: {'class': 'UL'},
                    ol: {'class': 'OL'},
                    li: {'class': 'listItem'},
                    a: {'target': '_blank'}
                }
            });
            $(div).find('.paragraph').html('{{ proInfo['intro'] }}');
			$('.prompt').click(function(e){
				var id = this.id,
				value = prompt( 'Value:' );
				editor[ id ]( value );
			});

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