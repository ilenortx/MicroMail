var data = {};
var saarr = Array();//发货地址
var cfhaddress = 0;
$(function(){
    var logistics_num = '';
    var template = '';

	/*$('#orderList').DataTable({
        bSort: true,
        bPaginate: true,
        bFilter: true,
        bInfo: true,
        iDisplayLength: 25,
    });*/
	$(document).click(function(){
		$('.choose-address-div').hide();
	})
	$('.re-fhdz-a').click(function(e){
		$('.choose-address-div').show();
		e = e || event; stopFunc(e);
	});
	$('.choose-address-div').click(function(e){
		e = e || event; stopFunc(e);
	});
    function stopFunc(e) {
        e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
    }

	for (var i in saarr){
		if (saarr[i].default == 'D1'){
			cfhaddress = saarr[i].id;
			var addr = $('<input type="radio" name="fhaddress" lay-filter="fhaddress" checked="checked" value="'+saarr[i].id+
					'" title="'+saarr[i].fhname+','+saarr[i].tel+','+saarr[i].aname+saarr[i].address+'" />');
		}else {
			var addr = $('<input type="radio" name="fhaddress" lay-filter="fhaddress" value="'+saarr[i].id+
					'" title="'+saarr[i].fhname+','+saarr[i].tel+','+saarr[i].aname+saarr[i].address+'" />');
		}
		$('.cadd-content').append(addr);
	}

	$('input[type=radio][name=fhaddress]').change(function() {
        alert($(this).val())
    });



    function sms_message(){
    	/*if(!confirm('确定发送订单发货短信吗？')) return;*/
        var o_status = $('#o_status').val();
        var order_status = $('#zt_order_update').val();
        /* 选择状态不能比当前状态小，已付款的订单不能变成未付款 */
        /* if (order_status && order_status!=40 && order_status<o_status) {return;}; */
        /* 获取快递名称 */
        var kuaidi_name = $('#kuaidi_name').val();
        if(kuaidi_name.length<1 && order_status==30) throw ('快递名称不能为空！');
        /* 获取快递单号 */
        var kuaidi_num = $('#kuaidi_num').val();
        if(kuaidi_num.length<1 && order_status==30) throw ('运单号不能为空！');

        if (!order_status && kuaidi_num.length<1 && kuaidi_name.length<1) {
            throw ('请输入快递信息或选择订单状态！');
        };

        /*$.post('../Order/saveOrder', {'order_status':order_status,'kuaidi_name':kuaidi_name,'kuaidi_num':kuaidi_num,'oid':{{ orderInfo['id'] }}, 'note':$('#note').val()}, function(data){
        	var data = jQuery.parseJSON(data);
        	if (data.status == 1){
        		layer.msg('操作成功!', { icon: 6,time: 1000 });
        		window.reload();
        	}else {
        		layer.msg(data.msg, { icon: 5,time: 1000 });
        	}
        });*/
    }

    $(document).on('click','.ivu-btn-create',function(){
        var ship_id = $('[name="city"]').val();

        $.post('../Logistics/createWebLogistics', {
            add_id: cfhaddress,
            ship_id: ship_id,
            data: [data['order_sn']],
        }, function(data) {
            if(data.status=='1'){
                template = data.data.PrintTemplate;
                logistics_num = data.data.order.ShipperCode;
                $('[name="logistics_num"]').val(logistics_num);

                layer.alert("生成电子面单成功", {icon: 6});
            }else{
                layer.alert(data.msg, {icon: 5});
                return;
            }
        },'json');
    });

    $('.ivu-btn-print').click(function(){
        if(logistics_num!=''){
            var html = '';
            openEdit('',$('#dialog_box').html(),500,300,1);
            form.render("select");
        }else{
            layer.alert('快递单号为空无法进行打印', {icon: 5});
            return;
        }
    });

    $('.ivu-btn-primary').click(function(){
        if(logistics_num!=''){
            $.post('../Order/updateOrderStatus',{
                status: 30,
                orders: [data['order_sn']],
                },function(data) {
                    if(data.status==1){
                        layer.alert("出货已完成", {icon: 6}, function(){
                            location.href = '../Order/orderList';
                        });
                    }else{
                        layer.alert(data.msg, {icon: 5});
                    }
            },'json');
        }else{
            layer.alert('快递单号为空无法出货', {icon: 5});
            return;
        }
    });

    layui.use('element', function(){
        var $ = layui.jquery, element = layui.element;
    });

    layui.use(['form', 'table'], function(){
        form = layui.form; table = layui.table;
        $.getScript("https://localhost:8443/CLodopfuncs.js",function(){init()});
    });

    function init(){
        LODOP.Create_Printer_List($('#print_sel')[0], true);
    }

    $(document).on('click','.submitAction',function(){
        LODOP.PRINT_INIT("");
        LODOP.SET_PRINTER_INDEX($('#print_sel').val());
        LODOP.SET_PRINT_PAGESIZE(0,'100mm','180mm');
        LODOP.ADD_PRINT_HTM(0,0,"100%","100%", template);
        LODOP.PREVIEW("_dialog");
    });
});