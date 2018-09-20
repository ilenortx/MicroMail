var form; 
var wlgsarr = Array();
$(function(){
	layui.use(['form', 'element'], function(){
		var $ = layui.jquery, element = layui.element;
		form = layui.form;
		
		//监听省份选择
	    form.on('select(cys)', function(data){
	        $('#wlgs').html('<option value="">请选择</option>'); $('#shi').attr("disabled",true);
	        var wlgsData = wlgsarr[data.value];
	        for(var i in wlgsData){
        		$("#wlgs").append('<option value="'+wlgsData[i].code+'">'+wlgsData[i].name+'</option>');
        	}
        	$('#wlgs').removeAttr("disabled");
            form.render('select');
	    });

	    //监听提交
	    form.on('submit(formSub)', function(data){
	    	var uploadFormData = new FormData($('#saveLc')[0]);
    		$.ajax({
    	        url:'../AMyDelivery/saveLc',
    	        type:"POST",
    	        contentType: false,
                processData: false,
    	        data:uploadFormData,
    	        success: function(data) {
    	        	data = JSON.parse(data);
    	        	if (data.status == 1){
        				layer.msg('操作成功!', { icon: 6, time: 1000 });
        				window.parent.reloadLCList();
        	        	layerClose();
        			}else { layer.msg(data.err, { icon: 5, time: 1000 }); }
    	        }
    	    });
	        return false;
	    });
	});
	
	
});
