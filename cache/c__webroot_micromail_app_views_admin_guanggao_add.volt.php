<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/respond.min.js"></script>
    <![endif]-->
    
	<?= $this->assets->outputCss('css1') ?>
	<link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
	<?= $this->assets->outputCss('css2') ?>
        
    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>新增广告</title>
</head>
<body style="min-height:auto">
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 广告管理 <span class="c-gray en">&gt;</span> 新增广告 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    <form class="form form-horizontal" action="../Guanggao/addAdv" method="post" onsubmit="return ac_from();" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>广告标题：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="广告标题" name="name" id="name" value="<?= $adinfo['name'] ?>">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>显示位置：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" id="position" name="position">
                    <!-- <option value="">无</option> -->
                    <option value="1" <?php if ($adinfo['position'] == 1) { ?> selected="selected" <?php } ?>>&nbsp;- 首页轮播</option>
                </select>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>跳转事件：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" id="type" name="type">
                    <option value="">无</option>
                    <option value="index" <?php if ($adinfo['type'] == 1) { ?>selected="selected" <?php } ?>>首页</option>
                </select>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>事件值：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="事件值" name="action" id="action" value="<?= $adinfo['action'] ?>">
                <span style="color:red;font-size: 12px;">跳转事件为首页时，无需填写 商品、新闻、商铺请填写相应的id值。</span>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>广告图片，大小：480*200</label>
            <div class="formControls col-xs-8 col-sm-3">
            	<?php if ($adinfo['photo']) { ?>
            	<img src="<?= $adinfo['photo'] ?>" width="200" height="100" /><br /><br />
            	<?php } ?>
                <input  type="file" name="file" id="file" value="">
                <input type="hidden" name="photo" id="photo" value="<?= $adinfo['photo'] ?>"/>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="排序" name="sort" id="sort" value="<?= $adinfo['sort'] ?>">
            </div>
        </div>


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <?php if ($adinfo['id']) { ?> <input type="hidden" name="adv_id" id="adv_id" value="<?= $adinfo['id'] ?>"> <?php } ?>
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
    function ac_from(){
        var name=document.getElementById('name').value;
        if(name.length<2){
            alert('广告标题长度不能少于2');
            return false;
        }
    }
</script>


</body>
</html>