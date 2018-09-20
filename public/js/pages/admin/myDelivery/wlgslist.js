var table, form, isDown=0; 
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use(['form', 'table'], function(){
		table = layui.table;
		form = layui.form;
		table.render({
			elem: '#logistics-table', id:'logistics',
			toolbar: '#logisticsTableToolbar', height:'full-60',
			title: '物流公司',	loading: true,
			url: '../AMyDelivery/shopwlgsList',
			defaultToolbar: ['filter', 'print'],
			where: {},
			cols: [[
				{type:'checkbox', fixed:'left'},
				{field:'name', width:200, title:'物流公司名称'},
				{field:'description', 'title':'物流公司描述'},
				{field:'printkd', width:100, align:'center', title:'打印快递单'},
				{field:'remark', title:'备注'},
				{field:'sort', width:80, align:'center', title:'排序'},
				{field:'default', width:100, align:'center', title:'默认快递'},
				{field:'operate', toolbar:'#bar-opcode', title:'操作'}
			]],
		});
		
		table.on('tool(logistics)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEdit('物流编辑','../AMyDelivery/wlgsAddPage?id='+data.id,600,400)
			}else if (layEvent === 'del'){
				layer.confirm('确认要删除?', function(index) {
					$.post('../AMyDelivery/delShopWlgs', {'id':data.id}, function(data){
		            	var datas = jQuery.parseJSON(data);
		              	if (datas.status == 1){
		              		layer.msg('已删除!', { icon: 6, time: 1000 });
		              		obj.del();
		            	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
		        	});
				});
			}else if(layEvent === 'edit'){
				openEdit('机器编辑','../Amachine/mEditPage?id='+data.id,850,400)
			}
		});
	});
});

/**
 * 发货地址列表重新加载
 */
function reloadLCList(){
	reloadTable('logistics', '../AMyDelivery/shopwlgsList', {});
}




