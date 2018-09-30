var table, form, laydate, isDown=0;
var qstatus='all', qtime, qorder;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});

	layui.use(['form', 'table', 'laydate'], function(){
		table = layui.table; form = layui.form; laydate = layui.laydate;
		table.render({
			elem: '#order-table',	page: true,
			id:'order', 			//toolbar: '#orderTableToolbar',
			title: '在售商品',	loading: true,
			height:'full-142',	limit: 30,
			url: '../Order/orderList',
			defaultToolbar: ['filter', 'print'],
			where: {},
			cols: [[
				{type:'checkbox', fixed:'left'},
				//{field:'id', width:60, sort:true, align:'center', title:'ID'},
				{field:'uname', width:150, title:'买家'},
				{field:'order_sn', width:200, sort:true, align:'center', 'title':'订单号'},
				{field:'price_h', width:80, align:'center', sort:true, title:'总金额'},
				//{field:'fxtc', width:100, sort:true, title:'分销商提成'},
				//{field:'price_h', width:100, align:'center', sort:true, title:'总金额(提成后)'},
				{field:'type', width:100, align:'center', sort:true, title:'支付类型'},
				{field:'status', width:80, align:'center', title:'状态'},
				{field:'addtime', width:180, sort:true, align:'center', title:'下单时间'},
				{field:'addtime', width:180, sort:true, align:'center', title:'付款时间'},
				{field:'note', width:80, fixed:'right', title:'备注'},
				{field:'operate', width:160, fixed:'right', title:'操作'},
			]],
		});

		table.on('tool(order)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;

			if (layEvent === 'openNote'){
				var grade = data.note_grade==null?0:data.note_grade;
				$("input[name='grade']:eq("+grade+")").attr("checked",'checked');
				$('.order_note_context').text(data.note==null?'':data.note);
				openEdit('备注', $('#noteGrade').html(), 520, 280, 1);
				form.render();

				$('.renote').on('click', function(){ renote(obj); });
			}
		});

		laydate.render({
		    elem: '#qpaytime', range: '~'
		});
	});

    $(document).on('click', '.print_logistics', function(){
        // var check_data = getCheckData('order');
        openEditFull('打印快递单','../Logistics/index');
    });

    $(document).on('click', '.print_order', function(){
        // var check_data = getCheckData('order');
        openEdit('打印出货单','../Logistics/printPage', 500, 400);
        // openEditFull('打印出货单','../Logistics/index');
    });
});

/**
 * 商品列表重新加载
 */
function reloadProList(){
	qtime = $('.qtime').val(); qorder = $('.qorder').val();
	reloadTable('order', '../Order/orderList', {'qstatus':qstatus, 'qtime':qtime, 'qorder':qorder});
}

function renote(obj){
	var tr = obj.tr;
	var gradeImg = $(tr).find('.gradeImg');

	var ong = $('input[name="grade"]:checked').val()
	var onc = $('.order_note_context').eq(1).val();

	$.post('../Order/renote', {'oid':obj.data.id, 'ong':ong, onc:onc}, function(data){
    	var datas = jQuery.parseJSON(data);
    	if (datas.status == 1){
    		var imgPath = [
    			'../img/common/note/note_gray.png', '../img/common/note/note_red.png',
    			'../img/common/note/note_yellow.png', '../img/common/note/note_green.png',
    			'../img/common/note/note_blue.png', '../img/common/note/note_purple.png'];
    		gradeImg.attr({src:imgPath[ong]});
    		obj.update({ note_grade: ong, note: onc });
    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
    });

	layer.closeAll();
}

function rqStatus(obj, status){
	qstatus = status;
	$('.ostatus').removeClass('layui-btn-warm');
	$(obj).addClass('layui-btn-warm');
	reloadProList();
}




