<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商品选择</title>
    {{ assets.outputCss() }} {{ assets.outputJs() }}
    
    <style>
    	.aaa_pts_show_2{ min-width:auto; }
    	.pro-ul{ list-style:none; }
    	.pro-ul li{ width:80px;height:100px;margin:10px;position:relative;float:left}
    	.pro-ul li img{ display:block;width:80px;height:80px;border-width:1px;border-style:solid;border-color:rgb(170, 170, 170);border-image:initial; }
    	.pro-ul .name-set{ width:80px;max-width:80px;line-height:20px;text-align:center;white-space:nowrap;text-overflow:ellipsis;cursor:default;overflow:hidden;}
    	.chooseTopFlag { width:18px;height:18px;position:absolute;left:1px;top:1px;display:none;background:url(../img/coustom/bg02.png?v=201711250202) no-repeat scroll -1158px -208px;background-color:#3bb0ff; }
    	
    </style>
</head>
<script>
	var pindex = 1;
	var proList = {{prolists}};
	var choosed = "{{choosed}}";
	choosed = choosed ? "{{choosed}}".split(',') : Array();
	console.log(choosed);
	function product_option(page) {
	    var obj = { "tuijian": $("#tuijian").val() };
	    var url = '?page=' + page;
	    $.each(obj, function (a, b) {
	        url += '&' + a + '=' + b;
	    });
	    location = url;
	}
	
	 /*选择返回*/
	function window_opener() {
	    var proIds = choosed.join(',');
	
	    window.opener.getPros(proIds);
	
	    window.close();
	}
	 
	function choosePor(obj){
		if ($(obj).attr('choose') == 'false'){
			$(obj).find('img').css({'border-color':'#3bb0ff'});
			$(obj).find('.chooseTopFlag').css({'display':'block'});
			
			$(obj).attr('choose', 'true');
			
			choosed.push($(obj).attr('proId'));
			$('#jishu').html('已添加活动产品'+choosed.length+'个');
		}else {
			$(obj).find('img').css({'border-color':'rgb(170, 170, 170)'});
			$(obj).find('.chooseTopFlag').css({'display':'none'});
			
			$(obj).attr('choose', 'false');
			choosed.splice($.inArray($(this).attr('proId'), choosed),1);
			$('#jishu').html('已添加活动产品'+choosed.length+'个');
		}
		
	};
</script>
<body>

    <div class="aaa_pts_show_1">【 产品选择 】</div>

    <div class="aaa_pts_show_2">
        <div class="aaa_pts_3">
            <div class="pro_4 bord_1">
                <div class="pro_5">
					<!-- 推荐产品：
                    <select class="inp_1 inp_6" id="tuijian">
                        <option value="">全部产品</option>
                        
                    </select> -->
                </div>
            </div>
            <ul class="pro-ul"></ul>
        </div>
    </div>
    
    <div style="display:flex;user-select:none;">
    	<span style="margin:auto;">
    		<a onClick="pageUp()">上一页</a>
    		<span id="pages">1/1</span>
    		<a onClick="pageDown()">下一页</a>
    	</span>
    	
    	<span id="jishu" style="margin-right:20px;">已添加活动产品0个</span>
    </div>
    <div style="display:flex;user-select:none;margin-top:20px;">
    	<span style="margin:auto;">
    		<button onclick="window_opener();" style="width:60px;height:30px;border-radius:5px;background:#49a3ff;border:1px solid #0064b5;">保存</button>
    		<button onclick="window.close();" style="width:60px;height:30px;border-radius:5px;background:#f5f5f5;border:1px solid #8f8f8f;margin-left:40px;">取消</button>
    	</span>
    </div>
    
    <script>
    	function createItem(){
    		$('.pro-ul').html('');
    		var html = '';
    		var plength = proList.length<pindex*18?proList.length:pindex*18;
    		for (var i=(pindex-1)*18; i<plength; ++i){
				var choose = 'false'; var display = 'none'; var bc = 'rgb(170, 170, 170)';
    			if (jQuery.inArray(proList[i].id, choosed)>=0){
    				choose = 'true'; display = 'block'; bc = '#3bb0ff';
    			}
    			
    			html += '<li class="pro-info" onClick="choosePor(this)" choose="'+choose+'" proId="'+proList[i].id+'">';
    			html += '<div class="chooseTopFlag" style="display:'+display+'"></div>';
    			html += '<img src="../files/uploadFiles/'+proList[i].photo_x+'" alt="" style="border-color:'+bc+'" />';
    			html += '<div class="name-set" title="'+proList[i].name+'">'+proList[i].name+'</div></li>';
    		}

			$('.pro-ul').html(html);

			var allpages = Math.ceil(proList.length/18)==0?1:Math.ceil(proList.length/18);
			$('#pages').html(pindex+'/'+allpages);
    	}
    	createItem();
		$('#jishu').html('已添加活动产品'+choosed.length+'个');
    	
    	/*上一页*/
    	function pageUp(){
    		if (pindex == 1) return false;
    		
    		pindex -= 1; createItem();
    	}
    	/*下一页*/
    	function pageDown(){
			if (pindex == Math.ceil(proList.length/18)) return false;
    		
    		pindex += 1; createItem();
    	}
    	
	</script>
</body>

</html>
