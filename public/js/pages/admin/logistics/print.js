var form = table = '';
$(document).ready(function(){
    var orders = [];
    var parent_data = parent.getCheckData('order');

    var print_html = $("html").clone();
    print_html.find('head').html("");
    print_html.find('body').html("<div id='order-info'></div><div id='table_box'></div>");
    print_html.find('#table_box').html("<table id='table_box' border='1' cellspacing='0' cellpadding='0'><thead><td width='24%'>商品编号</td><td width='8%'>数量</td><td width='16%'>属性</td><td width='28%'>商品名称</td><td width='12%'>价格</td><td width='12%'>小计</td></thead><tbody id='table_body'></tbody></table>").css('font-size', '12px');

    var style_html = $('html').html().match(/<style(([\s\S])*?)<\/style>/g);
    print_html.find('head').append(style_html);

    for (var i in parent_data) {
        orders.push(parent_data[i].order_sn);
    };

    layui.use('element', function(){
        var $ = layui.jquery, element = layui.element;
    });

    layui.use(['form', 'table'], function(){
        form = layui.form; table = layui.table;
        $.getScript("https://localhost:8443/CLodopfuncs.js",function(){init()});

        $('.submitAction').click(function(){
            $.post('../Logistics/print', {
                data: orders,
            }, function(data) {
                var return_data = data.data;
                var table_data = [];

                LODOP.PRINT_INIT("");
                LODOP.SET_PRINTER_INDEX($('#print_sel').val());
                // LODOP.SET_PRINT_PAGESIZE(0,'100mm','180mm','CreateCustomPage');
                // LODOP.SET_PRINT_STYLE('alignment', 2);
                // LODOP.SET_PRINT_STYLE('VOrient', 2);
                for(var j in return_data){
                    LODOP.NewPage();            // 新建打印页

                    print_html.find('#order-info').html('<div class="box-item"><p>订单编号：'+ return_data[j].order.order_sn +'</p><p class="f_right">应收金额：¥ '+ return_data[j].order.total_fee +'元</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>下单时间：'+ formatDateTime(return_data[j].order.addtime) +'</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>出库时间：'+ formatDateTime(return_data[j].order.fhtime) +'</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>商户姓名：'+ return_data[j].order.receiver +'</p><p class="f_right">联系方式：'+ return_data[j].order.tel +'</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>客户地址：'+ return_data[j].order.address + return_data[j].order.address_xq +'</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>买家备注：'+ return_data[j].order.remark +'</p></div>');
                    print_html.find('#order-info').append('<div class="box-item"><p>卖家备注：'+ return_data[j].order.note +'</p></div>');

                    var return_product = return_data[j].product;
                    var table_html = '';
                    for (var i in return_product) {
                        var push_data = {
                            pro_number: return_product[i].pro_number,
                            num: return_product[i].num,
                            attr: return_product[i].pro_attr,
                            name: return_product[i].name,
                            price: parseFloat(return_product[i].price) / parseFloat(return_product[i].num),
                            sum: return_product[i].price,
                        };

                        table_html += '<tr>';
                        table_html += '<td>'+ push_data['pro_number'] +'</td>';
                        table_html += '<td>'+ push_data['num'] +'</td>';
                        table_html += '<td>'+ push_data['attr'] +'</td>';
                        table_html += '<td>'+ push_data['name'] +'</td>';
                        table_html += '<td>'+ push_data['price'] +'</td>';
                        table_html += '<td>'+ push_data['sum'] +'</td>';
                        table_html += '</tr>';
                    };
                    print_html.find('tbody').html(table_html);

                    LODOP.ADD_PRINT_HTM(40,0,'100mm','180mm', print_html.html());        // 渲染打印
                }

                LODOP.PREVIEW("_dialog");
            },'json');
        });
    });

    function init(){
        LODOP.Create_Printer_List($('#print_sel')[0], true);

        form.render("select");
    }
});

function formatDateTime(inputTime) {
    if(parseInt(inputTime) > 0){
        var date = new Date(parseInt(inputTime) * 1000);
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        m = m < 10 ? ('0' + m) : m;
        var d = date.getDate();
        d = d < 10 ? ('0' + d) : d;
        var h = date.getHours();
        h = h < 10 ? ('0' + h) : h;
        var minute = date.getMinutes();
        var second = date.getSeconds();
        minute = minute < 10 ? ('0' + minute) : minute;
        second = second < 10 ? ('0' + second) : second;
        return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
    }else{
        return '';
    }
}