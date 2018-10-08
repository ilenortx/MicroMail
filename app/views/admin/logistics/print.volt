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

    <title></title>
    <style type="text/css">
        .layui-form{
            padding-top: 20px;
        }
        #order-info{
            width: 100%;
            font-size: 12px;
        }
        .box-item{
            line-height: 2.5;
            width: 100%;
            display: block;
            clear: both;
        }
        .box-item p{
            float: left;
        }
        .box-item p.f_right{
            float: right;
        }
        #table_box{
            width: 100%;
            font-size: 12px;
        }
    </style>
</head>

<body style="min-height:auto">
    <div class="page-container">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">打印机：</label>
                <div class="layui-input-block">
                    <select id="print_sel" lay-filter="print_control"></select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-btn submitAction">点击提交</div>
            </div>
        </form>
    </div>
</body>
</html>