var table, form, isDown=0; 
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use(['form', 'table'], function(){
		table = layui.table;
		form = layui.form;
		table.render({
			elem: '#shipAddress-table', id:'shipAddress',
			toolbar: '#shipAddressTableToolbar', height:'full-60',
			title: '发货地址',	loading: true,
			url: '../AMyDelivery/getSAList',
			defaultToolbar: ['filter', 'print'],
			where: {},
			cols: [[
				{type:'checkbox', fixed:'left'},
				{field:'aname', width:200, title:'地址'},
				{field:'address', sort:true, 'title':'详细地址'},
				{field:'postcode', width:100, align:'center', sort:true, title:'邮编'},
				{field:'tel', width:150, align:'center', sort:true, title:'联系电话'},
				{field:'fhname', width:150, align:'center', title:'发货人姓名'},
				{field:'defaultInfo', width:100, sort:true, align:'center', title:'默认'},
				{field:'operate', toolbar:'#bar-opcode', title:'操作'}
			]],
		});
		
		table.on('tool(shipAddress)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if (layEvent === 'openNote'){
				var grade = data.note_grade==null?0:data.note_grade;
				$("input[name='grade']:eq("+grade+")").attr("checked",'checked'); 
				$('.order_note_context').text(data.note==null?'':data.note);
				openEdit('备注', $('#noteGrade').html(), 520, 280, 1);
				form.render();
				
				$('.renote').on('click', function(){
					renote(obj);
				});
			}else if (layEvent === 'edit'){
				openEdit('修改地址','../AMyDelivery/saaddPage?id='+data.id,700,500)
			}else if(layEvent === 'del'){
				layer.confirm('确认删除收货地址？', function(index){
					$.post('../AMyDelivery/delSa', {'id':data.id}, function(data){
				    	var datas = jQuery.parseJSON(data);
				    	if (datas.status == 1){
				    		layer.msg('删除成功', { icon: 6, time: 1000 });
						 	obj.del();
				    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
				    });
				});
			}
		});
	});
});

/**
 * 发货地址列表重新加载
 */
function reloadSAList(){
	reloadTable('shipAddress', '../AMyDelivery/getSAList', {});
}




