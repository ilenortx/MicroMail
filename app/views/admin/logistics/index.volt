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

    {{ assets.outputCss() }}
    {{ assets.outputJs() }}

    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>全部订单</title>
    <style type="text/css">
        .page-container{ margin: 0; }
    </style>
</head>

<body style="min-height:auto">
    <div class="page-container">
        <form class="layui-form" action="">
            <div class="log-info">
                <div class="layui-form-item">
                    <label class="layui-form-label">选择打印机：</label>
                    <div class="layui-input-block">
                        <select id="print_sel" lay-filter="print_control"></select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择快递：</label>
                    <div class="layui-input-block">
                        <select name="ship_id" lay-filter="log_control">
                            {% for log_item in logistics %}
                            <option value="{{log_item['id']}}" {% if log_item['default']=='D1' %}selected="selected"{% endif %}>{{log_item['nickname']|default(log_item['name'])}}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">发货人信息：</label>
                    <div class="layui-input-block">
                        <select name="add_id">
                            {% for ship_item in shipping %}
                            <option value="{{ship_item['id']}}" {% if ship_item['default']=='D1' %}selected="selected"{% endif %}>{{ship_item['aname']}}{{ship_item['address']}} {{ship_item['fhname']}} {{ship_item['tel']}}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网店信息：</label>
                    <div class="layui-input-block">
                        <input type="text" name="netpoint_info" autocomplete="off" placeholder="网店信息" class="layui-input" readonly="readonly">
                        <em class="surplus">余量：<font id="ava_num">{{availableNum}}</font></em>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div>
                        <div class="layui-btn layui-btn-normal create_logistics">生成电子面单</div>
                        <div class="layui-btn layui-btn-normal print_action">打印快递单</div>
                        <div class="layui-btn layui-btn-danger delivery_action">批量出货</div>
                    </div>
                </div>
            </div>

            <table id="undeliveredData" lay-filter="log"></table>
        </form>
    </div>
</body>
</html>