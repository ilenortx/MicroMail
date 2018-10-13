var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	layui.use('table', function(){
		table = layui.table;
		
		table.on('tool(roles)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEdit('职位编辑','../Adminusers/roleEditPage?id='+data.id,'800','500')
			}else if(layEvent === 'del'){
				layer.confirm('真的删除行么', function(index){
				  	$.post('../Adminusers/roleDel', {'id':data.id}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                            layer.msg('已删除!', { icon: 6,time: 1000 });
                    		obj.del(); layer.close(index);
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
				});
			}
		});
	});
});

/*打开编辑*/
function openEdit(title, url, w, h){
	layer.open({
		type: 2,
		title: title,
		shadeClose: true,
		shade: 0.8,
		area: [w+'px', h+'px'],
		content: url
	});
}

/*应用重新加载*/
function reloadRoles(){
	table.reload('roles', {
		url: '../Adminusers/shopRoles'
	});
}

