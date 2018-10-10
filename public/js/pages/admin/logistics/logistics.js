var table, form;
var checkbox_data = '';
$(document).ready(function(){

    var check_data = parent.getCheckData('order');

    var order_nums = new Array();
    for(var i = 0; i < check_data.length; i++){
        order_nums.push(check_data[i].order_sn);
    }

    layui.use('element', function(){
        var $ = layui.jquery, element = layui.element;
    });

    layui.use(['form', 'table'], function(){
        form = layui.form; table = layui.table;

        $.getScript("//localhost:8443/CLodopfuncs.js",function(){init()});

        table.render({
            elem: '#undeliveredData',
            id: 'log',
            url: '../Logistics/getData',
            where: {order_sn: order_nums},
            title: '数据表格',
            height:'300',
            cols: [[
                {type:'checkbox', fixed:'left'},
                {field:'order_sn', title:'订单号', width:200},
                {field:'price_h', title:'订单金额', width:100},
                {field:'logistics_num', title:'快递单号', width:200},
                {field:'remark', title:'买家备注', width:400},
                {field:'addtime', title:'快递单号生成时间', width:120},
            ]],
            page: true,
            parseData: function(data){
                for (var i in data.data) {
                    if( checkbox_data.indexOf(data.data[i].order_sn) >= 0 ){
                        data.data[i].LAY_CHECKED = 'true';
                    }
                };

                return {
                    "code": data.code, //解析接口状态
                    "msg": data.msg, //解析提示文本
                    "count": data.count, //解析数据长度
                    "data": data.data //解析数据列表
                };
            },
        });

        form.on('select(log_control)', function(data){
            $.post('../logistics/changeLog', {shipId: data.value}, function(data) {
                if(data.status==1){
                    $('#ava_num').html(data.data.num);
                }else{
                    layer.alert(data.msg, {icon: 6});
                    return;
                }
            },'json');
        });

    });

    $('.create_logistics').click(function(){
        var sel_data = getCheckData('log');
        if(sel_data.length == 0){
            layer.alert('请选择订单', {icon: 6});
            return;
        }

        var new_array = [];
        for (var i in sel_data) {
            new_array.push(sel_data[i].order_sn);
        };

        checkbox_data = new_array.join(',');

        $.post('../Logistics/createWebLogistics',{
                data: new_array,
                ship_id: $('[name="ship_id"]').val(),
                add_id: $('[name="add_id"]').val(),
            },function(data){
                if(data.status==0){
                    layer.alert(data.msg, {icon: 5});
                    return;
                }
                layer.msg('生成成功', {icon: 6});
                table.reload('log');

                // layer.open({
                //     type: 1,
                //     title: false,
                //     area: ['500px', '600px'],
                //     shade: 0.8,
                //     closeBtn: 0,
                //     shadeClose: true,
                //     content: data.data.printTemplate,
                // });
            },'json'
        );
    });

    $('.print_action').click(function(){
        // var win_html = $(window.document.body).clone();
        // bdhtml=window.document.body.innerHTML;//获取当前页的html代码
        // sprnstr="<!--startprint-->";//设置打印开始区域
        // eprnstr="<!--endprint-->";//设置打印结束区域
        // prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
        // prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
        // window.document.body.innerHTML=prnhtml;
        // window.print();
        // window.document.body.innerHTML=win_html.html();

        // var html = '<!--startprint-->' + $('.print_box').html() + '<!--endprint-->';
        // html += '<script>bdhtml=window.document.body.innerHTML;sprnstr="<!--startprint-->";eprnstr="<!--endprint-->";prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18);prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));window.document.body.innerHTML=prnhtml;window.print();console.log(window.document.body);//window.document.body.innerHTML=bdhtml;</script>';

        var sel_data = getCheckData('log');
        var html_text = "";
        var body_array = [];
        for (var i in sel_data) {
            if(sel_data[i].template && sel_data[i].template!='' && html_text==''){
                //  /<style(([\s\S])*?)<\/style>/g
                html_text = sel_data[i].template.replace(/<body(([\s\S])*?)<\/body>/, "<!--replace_code-->");
            }

            body = sel_data[i].template.match(/<body[^>]*>([\s\S]*)<\/body>/);
            if(body && body.length === 2){
                body_array.push(body[1]);
                // body_text += '<div style="page-break-after: always;"></div>';
            }
            // layer.alert('选取的订单未生成快递单号，无法出库', {icon: 5});
        };

        // layer.open({
        //     type: 1,
        //     title: false,
        //     area: ['500px', '600px'],
        //     shade: 0.8,
        //     closeBtn: 0,
        //     shadeClose: true,
        //     content: body_text,
        // });
        // return;

        LODOP.PRINT_INIT("");
        LODOP.SET_PRINTER_INDEX($('#print_sel').val());
        LODOP.SET_PRINT_PAGESIZE(0,'100mm','180mm');
        LODOP.SET_PRINT_STYLE('alignment', 2);
        LODOP.SET_PRINT_STYLE('VOrient', 2);
        // LODOP.ADD_PRINT_TEXT(10,10,300,200,"");
        for(var j in body_array){
            LODOP.NewPage();
            LODOP.ADD_PRINT_HTM(0,0,"100%","100%", html_text.replace("<!--replace_code-->", body_array[j]));
        }
        // LODOP.On_Return=function(TaskID,Value){ alert("打印结果:"+Value); };
        LODOP.PREVIEW("_dialog");


        // obj.print();
    });

    $('.delivery_action').click(function(){
        var sel_data = getCheckData('log');

        var post_orders = [];
        for (var i in sel_data) {
            if(!sel_data[i].logistics_num || sel_data[i].logistics_num==''){
                layer.alert('选取的订单未生成快递单号，无法出库', {icon: 5});
                return;
            }

            post_orders.push(sel_data[i].order_sn);
        };

        if(post_orders.length == 0){
            layer.alert('请选择订单进行操作', {icon: 5});
            return;
        }

        $.post('../Order/updateOrderStatus',{
            status: 30,
            orders: post_orders,
            },function(data) {
                if(data.status==1){
                    layer.alert("批量出货已完成", {icon: 6}, function(){
                        parent.table.reload('order');
                        layerClose();
                    });
                }else{
                    layer.alert(data.msg, {icon: 5});
                }
        },'json');
    });

    function init(){
        LODOP.Create_Printer_List($('#print_sel')[0], true);

        form.render("select");
    }

    // LODOP.PRINT_INIT("测试端桥AO打印");
    // LODOP.SET_PRINTER_INDEX(iDriverIndex+','+strBridgeIDandName+','+iSubPrinterIndex);
    // LODOP.SET_PRINT_PAGESIZE(0,0,0,strPageSizeName);
    // // LODOP.ADD_PRINT_TEXT(10,10,300,200,"这是纯文本行");
    // LODOP.ADD_PRINT_HTM(30,10,"100%","80%","超文本横线:<hr>下面是二维码:");
    // // LODOP.ADD_PRINT_BARCODE(85,10,79,69,"QRCode","123456789012");
    // // LODOP.On_Return=function(TaskID,Value){ alert("打印结果:"+Value); };
    // LODOP.PREVIEW(true);
    // // LODOP.PRINT();
});

