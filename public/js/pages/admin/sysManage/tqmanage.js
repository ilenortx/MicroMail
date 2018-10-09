var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use('table', function(){
		table = layui.table;
		table.render({
			elem: '#tq-table',	page: true,
			id:'taskQueue',		toolbar: '#tqTableToolbar',
			title: '任务管理',	loading: true,
			height:'full-60',	limit: 30,
			url: '../Asysmanage/getTqls',
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
				{field:'remark', title:'备注'},
				{field:'sdesc', width:80, align:'center', title:'状态'},
				{field:'operate', width:160, title:'操作'},
			]]
		});
		
		table.on('tool(taskQueue)', function(obj){
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
	//var mcode = $('#taskQueue').val();
	reloadTable('taskQueue', '../Asysmanage/getTqls', {});
}

function del(){
	var ctqs = getCheckData();
	if (!ctqs.length) {layer.msg('请先选中需删除数据!', {  });return;}
	var ids = '';
	for(var i=0; i<ctqs.length; ++i){
		ids += ctqs[i].id+',';
	}
	
	executeDel(ids);
}
function getCheckData(){ //获取选中数据
	var checkStatus = table.checkStatus('taskQueue'),
	data = checkStatus.data;

	return data;
}

/*删除*/
function executeDel(ids, obj) {
    layer.confirm('确定删除任务？',
    function(index) {
    	$.post('../ASysManage/delTqs', {'ids':ids}, function(data){
        	var datas = jQuery.parseJSON(data);
        	if (datas.status == 1){
        		if (typeof(obj) != 'undefined') obj.del();
        		else reloadTqList();
                layer.msg('已删除!', { icon: 1,time: 1000 });
        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        });
    });
}