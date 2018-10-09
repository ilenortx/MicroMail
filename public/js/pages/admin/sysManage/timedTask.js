var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use('table', function(){
		table = layui.table;
		table.render({
			elem: '#tt-table',	loading: true,
			id:'timedTask',		title: '定时任务',
			height:'full-60',	url: '../Asysmanage/timedTasks',
			cols: [[
				{toolbar:'#bar-opcode', align:'center', width:160, title:'操作'},
				{field:'descript', 'title':'描述'},
				{field:'status', width:80, title:'开启'},
				{field:'rule', width:180, title:'规则'},
				{field:'letime', width:200, title:'最后执行时间'}
			]]
		});
		
		table.on('tool(timedTask)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if(layEvent === 'edit') {
				$.post('../Asysmanage/timedTaskInfo', {'id':data.id}, function(data){
		        	var datas = jQuery.parseJSON(data);
		        	if (datas.status == 1){
		        		openEdit('编辑计划任务', $('#eidtTemp').html(), 550, 390, 1);
		        		var rdata = datas.datas;
		        		$('#etid').text(rdata.id);
		        		$('#ettype').text(rdata.type);
		        		$('#etletime').text(rdata.letime);
		        		$('#etdescript').text(rdata.descript);
		        		$('#etrule').val(rdata.rule);
		        		$('#etstatus').val(rdata.status);
		        		
		        		$('#etsubmit').click(function(){
		        			$.post('../Asysmanage/reTimedTaskInfo', {'id':rdata.id, 'rule':$('#etrule').val(), 'status':$('#etstatus').val()}, function(data){
		        		    	var datas = jQuery.parseJSON(data);
		        		    	if (datas.status == 1){
		        		    		reloadList();
		        		    		layer.msg('提交成功', { icon: 6, time: 1000 });
		        		    		layer.closeAll();
		        		    	}else layer.msg(datas.err, { icon: 5, time: 1000 });
		        		    });
		        		});
		        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
		        });
			}else if (layEvent === 'excute') {
				$.post('../TaskOpe/execute', {'id':data.id}, function(data){
    		    	var datas = jQuery.parseJSON(data);
    		    	if (datas.status == 1){
    		    		reloadList();
    		    		layer.msg('执行成功', { icon: 6, time: 1000 });
    		    	}else layer.msg(datas.err, { icon: 5, time: 1000 });
    		    });
			}
		});
	});
});

/**
 * 商品列表重新加载
 */
function reloadList(){
	reloadTable('timedTask', '../Asysmanage/timedTasks', {});
}

function reTimedTaskInfo(id, rule, status){
	
}
