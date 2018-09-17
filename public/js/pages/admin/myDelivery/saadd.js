var form; 
$(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use(['form'], function(){
		table = layui.table;
		form = layui.form;
		
		//监听省份选择
	    form.on('select(sheng)', function(data){
	        $('#shi').html('<option value="">请选择市/县</option>'); $('#shi').attr("disabled",true);
	        $('#qu').html('<option value="">请选择镇区</option>'); $('#qu').attr("disabled",true);
	        $('#jd').html('<option value="">请选择街道</option>'); $('#jd').attr("disabled",true);
	        $.ajax( {
	            url:"../AMyDelivery/getAreaChild",
	            data: {aid: data.value},
	            type:'POST',
	            dataType:'json',
	            success:function(data1) {
	                if (data1.status == 1) {
	                	var option = data1.datas;
	                	for(var i=0; i<option.length; ++i){
	                		$("#shi").append('<option value="'+option[i].id+'">'+option[i].name+'</option>');
	                	}
	                	$('#shi').removeAttr("disabled");
	                    form.render('select');
	                }else layer.msg(data1.err, {  });
	            }
	        });
	    });
	    form.on('select(shi)', function(data){
	        $('#qu').html('<option value="">请选择镇区</option>'); $('#qu').attr("disabled",true);
	        $('#jd').html('<option value="">请选择街道</option>'); $('#jd').attr("disabled",true);
	        $.ajax( {
	            url:"../AMyDelivery/getAreaChild",
	            data: {aid: data.value},
	            type:'POST',
	            dataType:'json',
	            success:function(data1) {
	            	if (data1.status == 1) {
	                	var option = data1.datas;
	                	for(var i=0; i<option.length; ++i){
	                		$("#qu").append('<option value="'+option[i].id+'">'+option[i].name+'</option>');
	                	}
	                	$('#qu').removeAttr("disabled");
	                    form.render('select');
	                }else layer.msg(data1.err, {  });
	            }
	        });
	    });
	    form.on('select(qu)', function(data){
	        $('#jd').html('<option value="">请选择街道</option>'); $('#jd').attr("disabled",true);
	        $.ajax( {
	            url:"../AMyDelivery/getAreaChild",
	            data: {aid: data.value},
	            type:'POST',
	            dataType:'json',
	            success:function(data1) {
	            	if (data1.status == 1) {
	                	var option = data1.datas;
	                	for(var i=0; i<option.length; ++i){
	                		$("#jd").append('<option value="'+option[i].id+'">'+option[i].name+'</option>');
	                	}
	                	$('#jd').removeAttr("disabled");
	                    form.render('select');
	                }else layer.msg(data1.err, {  });
	            }
	        });
	    });


	    //监听提交
	    form.on('submit(formSub)', function(data){
	    	var uploadFormData = new FormData($('#saveSa')[0]);
    		$.ajax({
    	        url:'../AMyDelivery/saveSa',
    	        type:"POST",
    	        contentType: false,
                processData: false,
    	        data:uploadFormData,
    	        success: function(data) {
    	        	data = JSON.parse(data);
    	        	if (data.status == 1){
        				layer.msg('操作成功!', { icon: 6, time: 1000 });
        				window.parent.reloadSAList();
        	        	layerClose();
        			}else { layer.msg(data.err, { icon: 5, time: 1000 }); }
    	        }
    	    });
	        return false;
	    });
	});
	
	
});
