var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	layui.use('table', function(){
		table = layui.table;
		
		table.on('tool(admins)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEdit('管理员编辑','../Adminusers/adminEditPage?id='+data.id,'800','500')
			}else if(layEvent === 'cstatus'){
				var status = data.status=='S0'?'S1':'S0';
				var desc = status=='S0'?'确定停用该用户!':'确定启用该用户!';
				layer.confirm(desc, function(index){
				  	$.post('../Adminusers/setAdminUserStatus', {'uid':data.id, 'status':status}, function(data){
                    	var datas = jQuery.parseJSON(data);
                    	if (datas.status == 1){
                    		obj.update(datas.datas.auinfo);
                    		var desc = status=='S0'?'已停用!':'已启用!';
                            layer.msg(desc, { icon: 6,time: 1000 });
                            layer.close(index);
                    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
                    });
				});
			}else if(layEvent === 'del'){
				layer.confirm('真的删除行么', function(index){
				 	
				  	$.post('../Adminusers/setAdminUserStatus', {'uid':data.id, 'status':'S2'}, function(data){
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
function reloadAdmins(){
	table.reload('admins', {
		url: '../Adminusers/shopAdmin'
	});
}

