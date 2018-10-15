/**
 * 编辑 js文件
 */
$(document).ready(function(){
	//初始化操作码状态(应用页面)
	if ($('#pid').val()==0) $('#opcode-list-row').hide();
	$("#pid").change(function(){
		if ($(this).val()==0) $('#opcode-list-row').hide();
		else $('#opcode-list-row').show();
	});
	$('#icon').on("input", function(){//图标更换预览
		$('#icon-pvw').html($(this).val());
	});
});


/*应用保存*/
function editApp(){
	var id = $('#id').val();
	var name = $('#name').val();
	var ename = $('#ename').val();
	var path = $('#path').val();
	var icon = $('#icon').val();
	var sort = $('#sort').val();
	var remark = $('#remark').val();
	var pid = $('#pid').val();
	var oids = '';
	
	var opcodeList = $('.opcode-list:checked');
	for (var i=0; i<opcodeList.length; ++i){//获取所有操作编码
		oids += $(opcodeList[i]).val()+',';
	}
	
	if (!name || !icon) { layer.msg('请完整填写数据!', function(){ }); return false; }
	
	$.post('../Asysdeploy/appEdit', {id:id, name:name, ename:ename, path:path,
		icon:icon, sort:sort, remark:remark, pid:pid, oids:oids}, function(data){
		var data = JSON.parse(data);
		
		if (data.status == 1){
			if (!$('#id').val()){
				$('#name').val(''); $('#ename').val(''); $('#path').val('');
				$('#icon').val(''); $('#remark').val(''); $('#pid').val('');
				$('input[type=checkbox]').each(function(){ $(this).prop("checked", false); });
			}
			layer.msg('操作成功！', {time: 1000, icon:6});
			window.parent.reloadApps();//更新数据
		}else layer.msg(data.err, function(){ });
	});
}

/*操作编码保存*/
function editOpcode(){
	var id = $('#id').val();
	var name = $('#name').val();
	var code = $('#code').val();
	var sort = $('#sort').val();
	
	if (!name || !code) { layer.msg('请完整填写数据!', function(){ }); return false; }
	
	$.post('../Asysdeploy/opcodeEdit', {id:id, name:name, code:code, sort:sort}, function(data){
		var data = JSON.parse(data);
		
		if (data.status == 1){
			if (!$('#id').val()){
				$('#name').val(''); $('#code').val(''); $('#sort').val('');
			}
			layer.msg('操作成功！', {time: 1000, icon:6});
			window.parent.reloadOpcode();//更新数据
		}else layer.msg(data.err, function(){ });
	});
}

