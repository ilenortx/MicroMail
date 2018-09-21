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
			title: '物流管理',	loading: true,
			url: '../AMyDelivery/wlgsList',
			defaultToolbar: ['filter', 'print'],
			where: {},
			cols: [[
				{type:'checkbox', fixed:'left'},
				{field:'cys', width:150, title:'承运商'},
				{field:'name', width:150, title:'物流公司'},
				{field:'code', 'title':'编码'},
				{field:'tel', width:150, title:'电话'},
				{field:'remark', title:'备注'},
				{field:'isjscx', width:80, align:'center', title:'即时查询'},
				{field:'iswlgz', width:80, align:'center', title:'物流跟踪'},
				{field:'isdzmd', width:80, align:'center', title:'电子面单'},
				{field:'isqj', width:80, align:'center', title:'取件'},
				{field:'sort', width:60, align:'center', title:'排序'},
				{width:160, fixed:'right', toolbar:'#bar-opcode', title:'操作'}
			]],
		});
		
		table.on('tool(logistics)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEditFull('物流编辑','../AMyDelivery/wlgsmAddPage?id='+data.id)
			}else if (layEvent === 'del'){
				layer.confirm('确认要删除?', function(index) {
					$.post('../AMyDelivery/delWlgs', {'id':data.id}, function(data){
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
function reloadWlmList(){
	reloadTable('logistics', '../AMyDelivery/wlgsList', {});
}




