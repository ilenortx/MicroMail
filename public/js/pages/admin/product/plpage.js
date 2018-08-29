var table;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	layui.use('table', function(){
		table = layui.table;
		
		table.on('tool(pros)', function(obj){
			var data = obj.data;
			var layEvent = obj.event;
			var tr = obj.tr;
			
			if (layEvent === 'tjset'){
				var _this = this;
				var tjstatus = $(this).attr('tjstatus');
				var title = tjstatus=='0'?'确认要取消推荐吗？':'确认要推荐该商品？'
				layer.confirm(title, function(index) {
					$.post('../Product/proTj1', {'id':data.id, 'type':tjstatus}, function(data){
		            	var datas = jQuery.parseJSON(data);
		              	if (datas.status == 1){
		              		if (tjstatus == '0'){
			                	layer.msg('已取消推荐!', { icon: 5, time: 1000 });
		              			var xx = $(_this).attr('tjstatus');
		              			$(_this).html('<i class="Hui-iconfont">&#xe615;</i>');
		              			$(_this).attr({'tjstatus':'1', 'title':'推荐'});
		              			$(obj.tr[0].children[7]).html('');
		              		}else {
			                	layer.msg('推荐成功!', { icon: 6, time: 1000 });
		              			$(_this).html('<i class="Hui-iconfont">&#xe631;</i>');
		              			$(_this).attr({'tjstatus':'0', 'title':'取消推荐'});
		              			$(obj.tr[0].children[7]).html('<label style="color:green;">推荐</label>');
		              		}
		            	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
		        	});
				});
			}else if(layEvent === 'edit'){
				openEdit('机器编辑','../Amachine/mEditPage?id='+data.id,850,400)
			}else if(layEvent === 'del'){
				layer.confirm('真的删除行么', function(index){
					$.post('../Amachine/machineDel', {id:data.id}, function(data){
						var datas = JSON.parse(data);
				        
				    	if (datas.status == 1){
						 	obj.del();
				    		layer.msg('操作成功!', { icon: 6, time: 1000 });
				    	}else { layer.msg(datas.err, { icon: 5, time: 1000 }); }
					})
				  	layer.close(index);
				});
			}
		});
	});
});

/**
 * 商品列表重新加载
 */
function reloadProList(){
	var mcode = $('#pros').val();
	reloadTable('pros', '../Product/proList', {mcode:mcode});
}

/*编辑*/
function admin_edit(title, url, id, w, h) {
    layer_show(title, url, w, h);
}

/* 新品设置 */
function pro_new(pro_id, type){
    if (!pro_id) {eturn;}
    $.post("../Product/proNew",{pro_id:pro_id, type:type},function(data){
    	
        if (data.status==1) {
            if (type==0) {
                document.getElementById('new_'+pro_id).innerHTML='<a class="label err" onclick="pro_new('+pro_id+',1)">非新品</a>';
            }else{
                document.getElementById('new_'+pro_id).innerHTML='<a class="label blue" onclick="pro_new('+pro_id+',0)">新品上市</a>';
            }
        }else{
        	layer.msg(data.msg, { icon: 5, time: 1000 });
            return false;
        }
    },'json');
}

/* 热销设置 */
function pro_hot(pro_id,type){
    if (!pro_id) {return;}
    $.post("../Product/proHot",{pro_id:pro_id, type:type},function(data){
        if (data.status==1) {
            if (type==1) {
                document.getElementById('hot_'+pro_id).innerHTML='<a class="label err" onclick="pro_hot('+pro_id+',0);">热卖商品</if></a>';
            }else{
                document.getElementById('hot_'+pro_id).innerHTML='<a class="label succ" onclick="pro_hot('+pro_id+',1);">非热卖</if></a>';
            }
        }else{
            alert('操作失败，请稍后再试！');
            return false;
        }
    },'json');
}


/*删除*/
function admin_del(obj, id) {
    layer.confirm('确认要删除吗？',
    function(index) {
    	$.post('../Product/proDel', {'id':id}, function(data){
        	var datas = jQuery.parseJSON(data);
        	if (datas.status == 1){
        		$(obj).parents("tr").remove();
                layer.msg('已删除!', { icon: 1,time: 1000 });
        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        });
    });
}