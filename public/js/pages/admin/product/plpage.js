var table, isDown=0;
$(document).ready(function(){
	layui.use('element', function(){
		var $ = layui.jquery, element = layui.element;
	});
	
	layui.use('table', function(){
		table = layui.table;
		table.render({
			elem: '#pro-table',	page: true,
			id:'pros', 			toolbar: '#proTableToolbar',
			title: '在售商品',	loading: true,
			height:'full-60',	limit: 30,
			url: '../Product/proList',
			defaultToolbar: ['filter', 'print'],
			where: {isDown:isDown},
			cols: [[
				{type:'checkbox', fixed:'left', style:'height:91px'},
				{field:'id', width:60, sort:true, align:'center', title:'ID'},
				{field:'photo_x', width:150, align:'center', 'title':'图片'},
				{field:'brand_id', width:70, align:'center', title:'品牌'},
				{field:'name', sort:true, title:'产品名称'},
				{field:'pro_number', width:150, sort:true, title:'产品编码'},
				{field:'price_yh', width:100, align:'center', sort:true, title:'价格/元'},
				{field:'renqi', width:80, align:'center', sort:true, title:'人气'},
				{field:'attrs', width:130, align:'center', title:'属性(点击修改)'},
				{field:'stype', width:80, align:'center', fixed:'right', style:'height:91px', title:'推荐'},
				{field:'operate', width:160, fixed:'right', style:'height:91px', title:'操作'},
			]],
		});
		
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
		              			$(obj.tr[2].children[0]).html('');
		              		}else {
			                	layer.msg('推荐成功!', { icon: 6, time: 1000 });
		              			$(_this).html('<i class="Hui-iconfont">&#xe631;</i>');
		              			$(_this).attr({'tjstatus':'0', 'title':'取消推荐'});
		              			$(obj.tr[2].children[0]).html('<label style="color:green;">推荐</label>');
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
			}else if (layEvent == 'soldOut'){
				console.log(getCheckData('pros'));
			}
		});
	});
});

/**
 * 商品列表重新加载
 */
function reloadProList(){
	reloadTable('pros', '../Product/proList', {isDown:isDown});
}

/**
 * 商品上下架
 */
function soldOutIn(status){//0下架 1上架
	var proc = getCheckData('pros');
	if (!proc.length) {layer.msg('请先选择商品!', {  });return;}
	var ids = '';
	for(var i=0; i<proc.length; ++i){
		ids += proc[i].id+',';
	}
	
	existSoldOutIn(ids, status);
}
function existSoldOutIn(ids, status, obj){
	$.post('../Product/soldOutIn', {'ids':ids, status:status}, function(data){
    	var datas = jQuery.parseJSON(data);
    	if (datas.status == 1){
    		if (typeof(obj) != 'undefined') obj.del();
    		else reloadProList();
            layer.msg('下架成功!', { icon: 1,time: 1000 });
    	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
    });
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
function proDel(){
	var proc = getCheckData('pros');
	if (!proc.length) {layer.msg('请先选择商品!', {  });return;}
	var ids = '';
	for(var i=0; i<proc.length; ++i){
		ids += proc[i].id+',';
	}
	
	existProDel(ids);
}
function existProDel(ids, obj) {
    layer.confirm('确认要删除吗？',
    function(index) {
    	$.post('../Product/proDel', {'ids':ids}, function(data){
        	var datas = jQuery.parseJSON(data);
        	if (datas.status == 1){
        		reloadProList();
                layer.msg('已删除!', { icon: 1,time: 1000 });
        	}else layer.msg(datas.msg, { icon: 5, time: 1000 });
        });
    });
}



