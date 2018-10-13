/**
 * 模块维护 js文件
 */
var table, treeGrid=null, tableId='treeTable', layer=null;
$(document).ready(function(){
	layui.use(['element','table','jquery','treeGrid','layer'], function(){
		var $ = layui.jquery, element = layui.element;;
		treeGrid = layui.treeGrid; layer = layui.layer; table = layui.table;
		
		treeGrid.render({
			id:'apps',			elem: '#apps-table',
			title: '功能管理',	//toolbar: '#categoryTableToolbar',
			loading: true,		url: '../Asysdeploy/allApps',
			height:'100%',		//defaultToolbar: ['filter', 'print'],
			idField:'id',		treeId: 'id',
	        treeUpId: 'pid',	treeShowName: 'name',
	        iconOpen:false,		isOpenDefault:false,
	        cellMinWidth: 100,	heightRemove:[".dHead", 165],
			cols: [[
				{field:'id', width:60, sort:true, align:'center', title:'ID'},
				{field:'name', width:150, sort:true, 'title':'名称'},
				{field:'ename', width:150, sort:true, title:'英文名'},
				{field:'pid', width:80, align:'center', title:'上级ID'},
				{field:'path', width:100, title:'链接地址'},
				{field:'icon', width:60, title:'图标'},
				{field:'remark', title:'说明'},
				{field:'status', width:80, sort:true, title:'状态'},
				{width:160, toolbar:'#bar-apps', title:'操作'}
			]],
		});
		
		treeGrid.on('tool(apps)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEdit('功能编辑','../Asysdeploy/apEditPage?id='+data.id,'800','500')
			}else if(layEvent === 'del'){
				layer.confirm('真的删除行么', function(index){
					$.post('../Asysdeploy/appDel', {id:data.id}, function(data){
						var data = JSON.parse(data);
						
						if (data.status == 1){
							layer.msg('操作成功！', {time: 5000, icon:6});
							obj.del(); layer.close(index);
						}else layer.msg(data.err, function(){ });
					});
				 	
				});
			}
		});
		
		
		table.render({
			elem: '#opcode-table',	page: true,
			id:'opcode', 			//toolbar: '#proTableToolbar',
			title: '在售商品',		loading: true,
			height:'full-190',		limit: 30,
			url: '../Asysdeploy/allOpcode',
			cols: [[
				{field:'id', width:60, sort:true, align:'center', 'title':'ID'},
				{field:'name', width:150, sort:true, 'title':'名称'},
				{field:'code', width:150, sort:true, align:'right', title:'操作码'},
				{field:'status', width:150, sort:true, align:'center', title:'状态'},
				{field:'sort', width:100, sort:true, title:'排序'},
				{width:160, toolbar:'#bar-opcode', title:'操作'}
			]],
		});
		
		table.on('tool(opcode)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit'){
				openEdit('操作码编辑','../Asysdeploy/opcodeEditPage?id='+data.id,'500','300');
			}else if(layEvent === 'del'){
				layer.confirm('真的删除行么', function(index){
					$.post('../Asysdeploy/opcodeDel', {id:data.id}, function(data){
						var data = JSON.parse(data);
						
						if (data.status == 1){
							layer.msg('操作成功！', {time: 5000, icon:6});
							obj.del(); layer.close(index);
						}else layer.msg(data.err, function(){ });
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
function reloadApps(){
	table.reload('apps', {url: '../Asysdeploy/allApps'});
}

/*操作码重新加载*/
function reloadOpcode(){
	table.reload('opcode', {
		url: '../Asysdeploy/allOpcode'
	});
}

