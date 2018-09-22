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

        {{ assets.outputCss() }}
        {{ assets.outputJs() }}

        <!--[if IE 6]>
            <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
    </head>

    <body style="min-height:auto">
        <nav class="navb">
            <div class="breadcrumb">
                <i class="Hui-iconfont">&#xe67f;</i>首页
                <span class="c-gray en">&gt;</span>产品管理
                <span class="c-gray en">&gt;</span>
                <a href="javascript:void(0);" onclick="history.go(-1);">参数类型</a>
                <span class="c-gray en">&gt;</span>参数类型编辑
                <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                    <i class="Hui-iconfont">&#xe68f;</i>
                </a>
            </div>
        </nav>
    	<article class="page-container">
        	<form id="parm_form" class="form form-horizontal" enctype="multipart/form-data" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-2 col-sm-2">
                        <span class="c-red">*</span>类型名称：</label>
                    <div class="formControls col-xs-9 col-sm-3">
                        <input type="text" class="input-text" placeholder="选项名称" name="t_name" id="name" value="{{parmInfo['t_name']}}">
                        <input type="hidden" name="t_id" value="{{parmInfo['id']}}">
                    </div>
                </div>
                <div class="row cl">
                	<label class="form-label col-xs-2 col-sm-2">选项值：</label>
                    <div class="formControls col-xs-9">
                    	<input class="addItemBtn faiButton" type="button" value="添加值" onclick="addValItem()">
                    	<table class="val-table val-table-title">
                    		<tr>
                    			<th width="40%">选项值</th>
                                <th width="20%">选项类型</th>
                                <th width="25%">内容</th>
                    			<th width="15%">操作</th>
                    		</tr>
                    	</table>
                    	<div class='values'>
                    		<table id="val-tab" class='val-table var-values-table'>
                    			{% for val in parmInfo['values'] %}
			                    <tr class='val-tr'>
			                    	<td width="40%">
                                        <input class="input-text val-name" name="name" value="{{val['name']}}" type="text" />
                                        <input type="hidden" name="id" value="{{val['id']}}">
                                    </td>
                                    <td width="20%">
                                        <select name="type" onchange="selChange(this)">
                                            <option value="text" {% if val['type']=='text' %}selected="selected"{% endif %}>输入文本</option>
                                            <option value="select" {% if val['type']=='select' %}selected="selected"{% endif %}>下拉框</option>
                                        </select>
                                    </td>
                                    <td width="25%" class="option_text">
                                        {% if val['type']=='select' %}
                                        <span class="edit_option" onClick="editOption(this)" data-option="{{val['value']}}">编辑选项</span><text class="option_show">{{val['value']}}</text>
                                        {% endif %}
                                        <input type="hidden" name="value" value="{{val['value']}}">
                                    </td>
			                    	<td class="val-del" width="15%"><a onClick="delValItem(this)">删除</a><i class="Hui-iconfont downBtn" onclick="downAction(this)">&#xe674;</i><i class="Hui-iconfont upBtn" onclick="upAction(this)">&#xe679;</i></td>
			                    </tr>
			                    {% endfor %}
			                </table>
                    	</div>

                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btnp btn-primary radius" type="button" onClick="dataSub()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>

            <div id="option_colum">
                <input class="addItemBtn faiButton" type="button" value="添加值" onclick="addOptionItem()">
                <form method="get" id="option_form">
                    <table class="val-table val-table-title">
                        <tr>
                            <th width="499px">选项值</th>
                            <th width="98px">操作</th>
                        </tr>
                    </table>
                    <div class='values'>
                        <table id="option-tab" class='val-table var-values-table'>

                        </table>
                    </div>
                </form>
                <div id="option_submit" class="btnp btn-primary" onClick="optionSubmit()">提交</div>
            </div>
        </article>
        <!--_footer 作为公共模版分离出去-->
    </body>

</html>