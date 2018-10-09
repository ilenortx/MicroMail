var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	layui.use('table', function(){
		table = layui.table;
		table.render({
			elem: '#tq-table',	page: true,
			id:'tqrb',		toolbar: '#tqTableToolbar',
			title: '任务回收站',	loading: true,
			height:'full-60',	limit: 30,
			url: '../Asysmanage/tqrbList',
			defaultToolbar: ['filter', 'print'],
			cols: [[
				{type:'checkbox'},
				{field:'id', width:60, align:'center', sort:true, 'title':'ID'},
				{field:'name', width:150, sort:true, title:'任务名'},
				{field:'admin', width:100, title:'添加者'},
				{field:'tdesc', width:100, align:'center', title:'类型'},
				{field:'intime', width:150, sort:true, align:'center', title:'添加时间'},
				{field:'dotime', width:150, sort:true, title:'执行时间'},
				{field:'etime', width:150, sort:true, title:'完成时间'},
				{field:'remark', title:'备注'}
			]]
		});
		
		table.on('tool(tqrb)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'del') executeDel(data.id, obj);
		});
	});
});

/**
 * 商品列表重新加载
 */
function reloadTqList(){
	reloadTable('tqrb', '../Asysmanage/tqrbList', {});
}

/**
 * 还原
 */
function restore(){
	var ctqs = getCheckData();
	if (!ctqs.length) {layer.msg('请先选中需还原数据!', {  });return;}
	var ids = '';
	for(var i=0; i<ctqs.length; ++i){
		ids += ctqs[i].id+',';
	}
	
	layer.confirm('确定还原任务？',
	function(index) {
		$.post('../Asysmanage/restoreTqs', {'ids':ids}, function(data){
			var datas = jQuery.parseJSON(data);
		   	if (datas.status == 1){
		    	if (typeof(obj) != 'undefined') $(obj).parents("tr").remove();
		    	else reloadTqList();
		      	layer.msg('已删除!', { icon: 1,time: 1000 });
			}else layer.msg(datas.msg, { icon: 5, time: 1000 });
		});
	});
}

function delig(){
	var ctqs = getCheckData();
	if (!ctqs.length) {layer.msg('请先选中需删除数据，删除后数据不可找回!', {  });return;}
	var ids = '';
	for(var i=0; i<ctqs.length; ++i){
		ids += ctqs[i].id+',';
	}
	
	executeDel(ids);
}
function getCheckData(){ //获取选中数据
	var checkStatus = table.checkStatus('tqrb'),
	data = checkStatus.data;

	return data;
}

/*删除*/
function executeDel(ids) {
    layer.confirm('确定删除任务？',
    function(index) {
    	$.post('../Asysmanage/deligTqs', {'ids':ids}, function(data){
        	var datas = jQuery.parseJSON(data);
        	if (datas.status == 1){
        		reloadTqList();
                layer.msg('已删除!', { icon: 1,time: 1000 });
        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        });
    });
}