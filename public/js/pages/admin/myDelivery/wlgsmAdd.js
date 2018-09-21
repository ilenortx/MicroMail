var form; 
var wlgsarr = Array();
$(function(){
	layui.use(['form', 'element'], function(){
		var $ = layui.jquery, element = layui.element;
		form = layui.form;
		
	    //监听提交
	    form.on('submit(formSub)', function(data){
	    	var uploadFormData = new FormData($('#saveLc')[0]);
    		$.ajax({
    	        url:'../AMyDelivery/saveWlminfo',
    	        type:"POST",
    	        contentType: false,
                processData: false,
    	        data:uploadFormData,
    	        success: function(data) {
    	        	data = JSON.parse(data);
    	        	if (data.status == 1){
        				layer.msg('操作成功!', { icon: 6, time: 1000 });
        				window.parent.reloadWlmList();
        	        	layerClose();
        			}else { layer.msg(data.err, { icon: 5, time: 1000 }); }
    	        }
    	    });
	        return false;
	    });
	});
	
	
});
