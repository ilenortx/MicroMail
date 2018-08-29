mui.ready(function() {
	page.initWinWH();

	page.initCps();
	/*$('.pro-items-div').scroll(function() {　　
		var scrollTop = $(this).scrollTop();　　
		var scrollHeight = $('.pro-items-div')[0].scrollHeight;　　
		var windowHeight = $(this).height();　　
		if(scrollTop + windowHeight == (scrollHeight)) {
			page.loadPros();
		}
	});*/
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		offset: 0,
		shopId: 'all',
		categorys: [],
		pros: [],
		cgchecked: 0,
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
	initCps: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiCutPrice/categorys', {
			shop_id: app.d.shopId
		}, function(data) {
			var data = app.json.decode(data);

			var cglist = data.cglist;
			var prolist = data.prolist;

			_this.data.categorys = cglist;
			_this.data.pros = prolist;
			if(cglist.length) _this.data.cgchecked = cglist[0].id;

			for(var i in cglist) {
				if(_this.data.cgchecked == cglist[i].id) var fi = $('<div onclick="chooseCg(this,' + cglist[i].id + ')" class="fl-item flitem-on">' + cglist[i].name + '</div>');
				else var fi = $('<div onclick="chooseCg(this,' + cglist[i].id + ')" class="fl-item">' + cglist[i].name + '</div>');
				$('.flitems-div').append(fi);
			}

			_this.cprodom(prolist);
		});
	},
	cprodom: function(pros) {
		if(pros.length) page.data.offset += 1;
		var width = this.data.winWidth;
		var proImgWH = width * 0.48;
		var hi = app.d.hostImg;
		for(var i = 0; i < pros.length; ++i) {
			var goodsItem = $('<a href="../WPages/proDetailPage?productId=' + pros[i].id + '" class="goods-item"></a>');
			var gimg = $('<img src="' + hi + pros[i].photo_x + '" style="height:' + proImgWH + 'px;width:' + proImgWH + 'px;" />');
			var title = $('<text class="title">' + pros[i].name + '</text>');
			var price = $('<div class="price">￥' + pros[i].price_yh + '</div>');
			goodsItem.append(gimg);
			goodsItem.append(title);
			goodsItem.append(price);

			$('.pro-items-div').append(goodsItem);
		}
	}
}

function loadPros(callback) {
	mui.post(app.d.hostUrl + 'ApiCutPrice/getpcgProList', {
		pcid: page.data.cgchecked,
		shop_id: app.d.shopId,
		offset: page.data.offset
	}, function(data) {
		var data = app.json.decode(data);
		
		if(data.status == 1){
			var prolist = data.prolist;
			for(var i = 0; i < prolist.length; ++i) {
				page.data.pros.push(prolist[i]);
			}
			page.cprodom(prolist);
		}
		if (typeof(callback)!='undefined') callback(data.status==0 || data.prolist.length==0);
	});
}
function chooseCg(obj, i) {
	$('.fl-item').removeClass('flitem-on');
	$(obj).addClass('flitem-on');

	page.data.cgchecked = i;
	page.data.pros = [];
	page.data.offset = 0;
	$('.pro-items-div').html('');
	loadPros();
}