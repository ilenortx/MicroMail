/**
 * 商品导入js
 */
$(function () {
	$('#cfBtn').click(function(){
		$('#efile').click();
	});
	$('#textfield').click(function(){
		$('#efile').click();
	});
});

var subStatus = false;
function subProExcel(){
	if (subStatus) { layer.msg('速度有点慢，请耐心等待!', {  }); return false; }
	if (!$('#efile').val()){ layer.msg('请填选择文件!', {  }); return false; }
	var pedata = new FormData($('.pei-form')[0]);
	subStatus = true;
	$.ajax({
		url:'../product/subProExcel',
	  	type:"POST",
	  	contentType: false,
       	processData: false,
      	data: pedata,
	 	success: function(data) {
	        data = JSON.parse(data);
	        if (data.status == 1){
    			layer.msg('已添加至任务列表!', { icon: 6, time: 1400 });
    			setTimeout(function(){
    		        subStatus = false;
    				layerClose();
    			}, 1500);
    		}else {
    			layer.msg(data.err, { icon: 5, time: 1000 });
    		}
	  	},
		error: function(){ subStatus = false; }
	});
}