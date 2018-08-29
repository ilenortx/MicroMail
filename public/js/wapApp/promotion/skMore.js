mui.ready(function() {
	page.initWinWH();

	page.loadSks();
	$(window).scroll(function() {　　
		var scrollTop = $(this).scrollTop();　　
		var scrollHeight = $(document).height();　　
		var windowHeight = $(this).height();　　
		if(scrollTop + windowHeight == (scrollHeight)) {
			page.loadPros();
		}
	});
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		offset: 0,
		shopId: 'all',
		pros: [],
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
	loadSks: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiPromotion/skList', {
			shop_id: app.d.shopId, offset: _this.data.offset
		}, function(data) {
			var data = app.json.decode(data);
            if (data.status == 1) {
            	var sklist = data.sklist;
            	_this.pCountDown();
            	for (var i in sklist){
            		_this.data.pros.push(sklist[i]);
            	}
            	
            	_this.cdom(sklist);
       		} else {
                alert(data.err);
        	}
		});
	},
	cdom: function(pros) {
		var hi = app.d.hostImg;
		for (var i in pros){
			var pivi = $('<a href="../WPages/proDetailPage?productId='+ pros[i].proInfo.id +'" class="pro-item-viewcarts-item"></a>');
			pivi.append('<img class="pro-image" src="'+hi+pros[i].proInfo.photo_x+'"/>');
			
			var pd = $('<div class="pro-detail"></div>');
			var pn = $('<text class="pro-name">'+pros[i].name+'</text>');
			var djs = $('<div class="djs">');
			djs.append('<text >距离结束</text>');
			djs.append('<text class="sytime-'+pros[i].proInfo.id+'" style="color:#c60000">00:00:00</text>');
			
			var ppv = $('<div class="pro-prices-view"></div>');
			ppv.append('<text class="hd-price">￥'+pros[i].pprice+'</text>');
			ppv.append('<text class="y-price">￥'+pros[i].proInfo.price_yh+'</text>');
			
			pd.append(pn); pd.append(djs); pd.append(ppv);
			
			pivi.append(pd);
			
			$('.mui-content').append(pivi);
		}
	},
	pCountDown: function () {//倒计时
        var _this = this;
        var pList = this.data.pros;
        for (var k in pList) {
            $('.sytime-'+pList[k].proInfo.id).text(app.timeFormat(pList[k].etime));
        }
        setTimeout(function () { _this.pCountDown(); }, 1000);
    },
}
