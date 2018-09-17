var data = [], form;
layui.use(['form', 'table'], function(){
	form = layui.form;
});
$(function(){
	
	$('#addNote').click(function(){
		var grade = data.note_grade==null?0:data.note_grade;
		$("input[name='grade']:eq("+grade+")").attr("checked",'checked'); 
		$('.order_note_context').text(data.note==null?'':data.note);
		openEdit('备注', $('#noteGrade').html(), 520, 280, 1);
		form.render();
		
		$('.renote').on('click', function(){
			renote();
		});
	});
	
	
	//复制订单号
	var clipboard = new ClipboardJS('#copyImg', {
        text: function() {
            return $('.order_sn-text').text();
        }
    });
	clipboard.on('success', function(e) {
		layer.msg('复制成功！', {  });
	});
	clipboard.on('error', function(e) {
		layer.msg('复复制失败！', {  });
	});
});


function renote(){
	var ong = $('input[name="grade"]:checked').val()
	var onc = $('.order_note_context').eq(1).val();
	
	$.post('../Order/renote', {'oid':data.id, 'ong':ong, onc:onc}, function(data){
    	var datas = jQuery.parseJSON(data);
    	if (datas.status == 1){
    		var imgPath = [
    			'../img/common/note/note_gray.png', '../img/common/note/note_red.png',
    			'../img/common/note/note_yellow.png', '../img/common/note/note_green.png',
    			'../img/common/note/note_blue.png', '../img/common/note/note_purple.png'];
    		$('#ngImg').attr({src:imgPath[ong]});
    		$('.note-text').text(onc);
    		
    		data.note_grade = ong; data.note = onc;
    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
    });
	
	layer.closeAll();
}


