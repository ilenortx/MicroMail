var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	layui.use('table', function(){
		table = layui.table;
		
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
	reloadTable('taskQueue', '../ATaskQueue/getTqls', {});
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
    	$.post('../ATaskQueue/delTqs', {'ids':ids}, function(data){
        	var datas = jQuery.parseJSON(data);
        	if (datas.status == 1){
        		if (typeof(obj) != 'undefined') obj.del();
        		else reloadTqList();
                layer.msg('已删除!', { icon: 1,time: 1000 });
        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        });
    });
}