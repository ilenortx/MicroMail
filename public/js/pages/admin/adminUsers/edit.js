/**
 * 编辑 js文件
 */
$(document).ready(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
	
});


/*职位保存*/
function editRole(){
	var id = $('#id').val();
	var name = $('#name').val();
	var remark = $('#remark').val();
	var oitems = '';
	
	var opcodeItem = $('.opcode-item:checked');
	for (var i=0; i<opcodeItem.length; ++i){//获取所有操作编码
		oitems += $(opcodeItem[i]).val()+',';
	}
	
	if (!name || !oitems.length) { layer.msg('请完整填写数据!', function(){ }); return false; }
	
	$.post('../Adminusers/roleEdit', {id:id, name:name, remark:remark, oitems:oitems}, function(data){
		var data = JSON.parse(data);
		
		if (data.status == 1){
			if (!$('#id').val()){
				$('#name').val(''); $('#remark').val('');
				$('input[type=checkbox]').each(function(){ $(this).prop("checked", false); });
			}
			layer.msg('操作成功！', {time: 1000, icon:6});
			window.parent.reloadRoles();//更新数据
		}else layer.msg(data.err, function(){ });
	});
}

/*管理员保存*/
function editAdmin(){
	var id = $('#id').val();
	var name = $('#name').val();
	var uname = $('#uname').val();
	var pwd = $('#pwd').val();
	var qpwd = $('#qpwd').val();
	var phone = $('#phone').val();
	var email = $('#email').val();
	var mtyp = $('#mtype').val();
	var roles = '';
	
	var roleItem = $('.role-item:checked');
	for (var i=0; i<roleItem.length; ++i){//获取所有操作编码
		roles += $(roleItem[i]).val()+',';
	}
	
	if (!name || !uname || (mtyp!='T0'&&!roles.length)) { layer.msg('请完整填写数据!', function(){ }); return false; }
	if (mtyp!='T0' && (!pwd || !qpwd || pwd!=qpwd)) { layer.msg('两次密码不同!', function(){ }); return false; }
	
	$.post('../Adminusers/adminEdit', {id:id, name:name, uname:uname, pwd:pwd,
		phone:phone, email:email, roles:roles, mtyp:mtyp}, function(data){
		var data = JSON.parse(data);
		
		if (data.status == 1){
			if (!$('#id').val()){
				$('#aeForm')[0].reset();
			}
			layer.msg('操作成功！', {time: 1000, icon:6});
			window.parent.reloadAdmins();//更新数据
		}else layer.msg(data.err, function(){ });
	});
}


/*管理员保存*/
function editShopRight(){
	var oitems = '';
	
	var opcodeItem = $('.opcode-item:checked');
	for (var i=0; i<opcodeItem.length; ++i){//获取所有操作编码
		oitems += $(opcodeItem[i]).val()+',';
	}
	
	if (!oitems.length) { layer.msg('必须选择一项!', function(){ }); return false; }
	
	$.post('../Adminusers/shopRightEdit', {oitems:oitems}, function(data){
		var data = JSON.parse(data);
		
		if (data.status == 1){
			layer.msg('操作成功！', {time: 1000, icon:6});
		}else layer.msg(data.err, function(){ });
	});
}

