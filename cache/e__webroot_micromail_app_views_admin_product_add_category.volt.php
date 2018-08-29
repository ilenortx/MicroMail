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
    
    <title><?php if ($edit) { ?>分类编辑<?php } else { ?>新增分类<?php } ?></title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 分类管理 <span class="c-gray en">&gt;</span> <?php if ($edit) { ?>分类编辑<?php } else { ?>新增分类<?php } ?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form class="form form-horizontal" action="../Category/save" method="post" onsubmit="return ac_from();" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属分类：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" name="tid" id="tid">
                    <?php foreach ($categoryLists as $list1) { ?>
                    	<?php if ($list1['id'] == $cginfo['tid']) { ?>
                            <option value="<?= $list1['id'] ?>" id="cate_<?= $list1['id'] ?>" name="one" selected="selected">- <?= $list1['name'] ?></option>
                        <?php } else { ?>
                            <option value="<?= $list1['id'] ?>" id="cate_<?= $list1['id'] ?>}" name="one">- <?= $list1['name'] ?></option>
                        <?php } ?>
                        <?php foreach ($list1['list2'] as $list2) { ?>
                        	<?php if ($list2['id'] == $cginfo['tid']) { ?>
                                <option value="<?= $list2['id'] ?>" id="cate_<?= $list2['id'] ?>" name="two" selected="selected">&nbsp; &nbsp;- <?= $list2['name'] ?></option>
                            <?php } else { ?>
                                <option value="<?= $list2['id'] ?>" id="cate_<?= $list2['id'] ?>" name="two">&nbsp; &nbsp;- <?= $list2['name'] ?></option>
                            <?php } ?>
                            <?php foreach ($list2['list3'] as $list3) { ?>
                                <option value="<?= $list3['id'] ?>" id="cate_<?= $list3['id'] ?>" name="three">&nbsp; &nbsp;&nbsp; &nbsp;- <?= $list3['name'] ?></option>
                            <?php } ?>
                    	<?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分类名称：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="分类名称" name="name" id="name" value="<?= $cginfo['name'] ?>">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>略缩图，图片大小200*200</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type='hidden' name="bz_1" id="photo_sj0" value="<?= $cginfo['bz_1'] ?>">
                <?php if ($cginfo['bz_1']) { ?>
                <img src="<?= $imgPath ?><?= $cginfo['bz_1'] ?>" width="200" height="200" />
                <?php } ?>
                <input type="file" name="file" id="bz_1" />
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分类介绍：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <textarea class="inp_1 inp_8" name="concent" id="concent" /><?= $cginfo['concent'] ?></textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排 序：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="排序" name="sort" id="sort" value="<?= $cginfo['sort'] ?>">
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <?php if ($edit) { ?><input type="hidden" name="cid" id="cid" value="<?= $cginfo['id'] ?>"><?php } ?>
            </div>
        </div>
    </form>
</div>
<!--_footer 作为公共模版分离出去-->
<?= $this->assets->outputJs('js1') ?>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<?= $this->assets->outputJs('js2') ?>

</body>
</html>