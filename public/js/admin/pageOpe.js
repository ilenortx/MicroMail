/**
 * 页面操作js
 */


/**
 * 关闭弹出框口
 */
function layerClose(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}

/**
 * 打开编辑
 * @param title
 * @param url
 * @param w
 * @param h
 * @returns
 */
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
/**
 * 全屏打开编辑
 * @param title
 * @param url
 * @returns
 */
function openEditFull(title, url){
	var index = layer.open({
	    type: 2,
		title: title,
		shade: 0.8,
	    content: url
	});
	layer.full(index);
}

/**
 * 应用重新加载
 */
function reloadTable(id, url, where={}){
	table.reload(id, {
		url: url,
        where: where
	});
}

/**
 * 输入框验证
 * @param obj
 * @param type
 * @returns
 */
function inputVerify(obj, type='int'){
	var verify = '';
	switch (type){
		case 'nmint'://非负整数
			verify = /^\\d+$/;
			break;
		case 'pint'://正整数
			verify = /^[0-9]*[1-9][0-9]*$/;
			break;
		case 'mint'://负整数
			verify = /^((-\\d+)|(0+))$/;
			break;
		case 'int'://整数
			verify = /^-?\\d+$/g;
			break;
		case 'nmfloat'://非负浮点数
			verify = /^\d+(\.\d+)?$/;
			break;
		case 'pfloat'://正浮点数
			verify = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/g;
			break;
		case 'mfloat'://非正浮点数
			verify = /^(-(([0-9]+\\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\\.[0-9]+)|([0-9]*[1-9][0-9]*)))$/;
			break;
		case 'float'://浮点数
			verify = /^(-?\d+)(\.\d+)?$/;
			break;
	}
	//数字验证
	if (!verify.test($(obj).val())) {
		$(obj).val($(obj).val().replace(/[^0-9.]/ig,""));
	}
}
