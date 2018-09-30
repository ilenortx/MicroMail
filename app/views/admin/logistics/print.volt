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
                <button class="layui-btn" lay-submit="" lay-filter="doPrint">点击提交</button>
            </div>
        </form>
    </div>

    <div class="hidden-box">
        <div class="box-item">
            <p>订单编号：123456789</p>
            <p>应收金额：¥123元</p>
        </div>
        <div class="box-item">
            <p>下单时间：</p>
        </div>
        <div class="box-item">
            <p>出库时间：</p>
        </div>
        <div class="box-item">
            <p>商户姓名：</p>
            <p>联系方式：</p>
        </div>
        <div class="box-item">
            <p>客户姓名：</p>
        </div>
        <div class="box-item">
            <p>买家备注：</p>
        </div>
        <div class="box-item">
            <p>卖家备注：</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>商品编号</th>
                    <th>数量</th>
                    <th>属性</th>
                    <th>商品名称</th>
                    <th>价格</th>
                    <th>小计</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>data</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
$(document).ready(function(){
    var form = table = '';
    var orders = [];
    var parent_data = parent.getCheckData('order');

    for (var i in parent_data) {
        orders.push(parent_data[i].order_sn);
    };

    layui.use('element', function(){
        var $ = layui.jquery, element = layui.element;
    });

    layui.use(['form', 'table'], function(){
        form = layui.form; table = layui.table;

        form.on('submit(doPrint)', function(data){
            $.post('../Logistics/print', {
                data: orders,
            }, function(data) {

            },'json');
        });
    });

    $.getScript("https://localhost:8443/CLodopfuncs.js",function(){init()});

    function init(){
        LODOP.Create_Printer_List($('#print_sel')[0], true);

        form.render("select");
    }
});
</script>