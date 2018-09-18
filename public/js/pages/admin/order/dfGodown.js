var saarr = Array();//发货地址
var cfhaddress = 0;
$(function(){
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
});