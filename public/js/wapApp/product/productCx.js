mui.ready(function() {
	page.initWinWH();
	$('#adimg').height(page.data.winWidth);
//	$('.proImg1').height((page.data.winWidth-20)/3*2);
//	$('.proImg2').width((page.data.winWidth-30)/2).height((page.data.winWidth-30)/2);
	
	page.loadProCx();
	
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		cxid: 0,
		offset: 0,
        procx: [],
        procxList: [],
        sstyle: 'S1'
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
	
	loadProCx: function(){//加载促销数据
		
		var _this = this;
		
		mui.post(app.d.hostUrl + 'ApiProduct/proCxList', {
			cxid: _this.data.cxid, offset: _this.data.offse
		}, function(data) {
			var data = app.json.decode(data);
	
			if(data.status == 1) {
				var hi = app.d.hostImg;
				_this.data.offset+=1;
				
				_this.data.procx = data.procx;
				for(var i in data.cxlist){
					_this.data.procxList.push(data.cxlist[i]);
				}
				
				//广告图
				if (data.procx.adphoto) {
					$('#adimg').show(); $('#adimg').attr({'src':hi+data.procx.adphoto});
				}
				
				//
				_this.data.sstyle = data.procx.sstyle;
				_this.cdom( data.cxlist);
			} else {
				alert(data.err);
			}
		});
	},
	
	cdom: function(procxList){
		var hi = app.d.hostImg;
		if (this.data.sstyle == 'S1'){
			for (var i in procxList){
				var img = $('<img onclick="goPro('+procxList[i].id+')" class="proImg1" src="'+hi+procxList[i].photo_tj+'" />');
				img.height((page.data.winWidth-20)/3*2);
				$('#proList').append(img);
			}
		}else {
			for (var i in procxList){
				var img = $('<img onclick="goPro('+procxList[i].id+')" class="proImg2" src="'+hi+procxList[i].photo_tjx+'" />');
				img.width((page.data.winWidth-30)/2).height((page.data.winWidth-30)/2);
				if (i%2==0) img.css('margin-right','10px');
				$('#proList').append(img);
			}
		}
	}
}

function goPro(id){
	window.location.href = "../WPages/proDetailPage?productId="+id;
}
