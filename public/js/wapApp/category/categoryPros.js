mui.ready(function() {
	loadPros();
	page.initWinWH();

	//	$(window).scroll(function() {　　
	//		var scrollTop = $(this).scrollTop();　　
	//		var scrollHeight = $(document).height();　　
	//		var windowHeight = $(this).height();　　
	//		if(scrollTop + windowHeight == (scrollHeight)) {
	//			page.loadPros();
	//		}
	//	});

	$('.showType').click(function() {
		var type = $(this).attr('type');
		$('.pro-list-div').html('');
		if(type == '1') {
			page.sllist(page.data.pros);
			$(this).attr({
				'src': '../img/wapApp/sllist.png',
				'type': '2'
			});
			page.data.showType = 2;
		} else {
			page.dllist(page.data.pros);
			$(this).attr({
				'src': '../img/wapApp/dllist.png',
				'type': '1'
			});
			page.data.showType = 1;
		}
	});

});

var page = {
	data: {
		offset: 0,
		shopId: 'all',
		winWidth: 0,
		winHeight: 0,
		cgid: 0,
		px: 0, //0、综合 1、最新 2、价格升 3、价格降 4、销量
		pros: [],
		showType: 1, //显示类型 1单列 2双列
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
	dllist: function(obj) {
		var hi = app.d.hostImg;
		for(var i in obj) {
			var proItem = $('<a href="../WPages/proDetailPage?productId=' + obj[i].id + '" class="pro-item1"></a>');

			var img = $('<img src="' + hi + obj[i].photo_x + '" style="width:100px;height:100px" />');
			var piright = $('<div class="pi-right">');

			var proname = $('<div class="proname">' + obj[i].name + '</div>');
			var xk = $('<div style="display:flex;align-content:center;font-size:14px;justify-content:space-between;color:#000;"></div>');
			var xp = $('<text>新品</text>');
			var kc = $('<text>库存：' + obj[i].num + '</text>');
			xk.append(xp);
			xk.append(kc);
			var jg = $('<div style="display:flex;align-content:center;font-size:14px;margin-top:5px;"></div>');
			var yh = $('<text style="color:red;min-width:80px;">￥ ' + obj[i].price_yh + '</text>');
			var yj = $('<text style="text-align:left;min-width:80px;margin-right:10rpx;text-decoration:line-through;color:#999;">￥' + obj[i].price + '</text>');
			jg.append(yh);
			jg.append(yj);
			piright.append(proname);
			piright.append(xk);
			piright.append(jg);

			proItem.append(img);
			proItem.append(piright);

			$('.pro-list-div').append(proItem);
		}
	},
	sllist: function(obj) {
		var hi = app.d.hostImg;
		var width = this.data.winWidth;
		var proImgWH = width * 0.28;
		for(var i in obj) {
			var proItem = $('<a href="../WPages/proDetailPage?productId=' + obj[i].id + '" class="goods-item"></a>');
			var img = $('<img src="' + hi + obj[i].photo_x + '" style="height:' + proImgWH + 'px;width:' + proImgWH + 'px;" />');
			var title = $('<text class="title">' + obj[i].name + '</text>');
			var price = $('<div class="price">￥' + obj[i].price_yh + '</div>');

			proItem.append(img);
			proItem.append(title);
			proItem.append(price);

			$('.pro-list-div').append(proItem);
		}
	}
}

function loadPros(callback) {
	var proList = $('.pro-list-div');
	if(page.data.offset == 0) proList.html('');

	mui.post(app.d.hostUrl + 'ApiCategory/loadPros', {
		cgid: page.data.cgid,
		shopId: page.data.shopId,
		offset: page.data.offset,
		sort: page.data.px
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			page.data.offset += 1;
			for(var k in data.pros) {
				page.data.pros.push(data.pros[k]);
			}

			var pros = page.data.pros;
			if(page.data.showType == 1) page.dllist(data.pros);
			else page.sllist(data.pros);
		}
		
		if (typeof(callback)!='undefined') callback(data.status==0 || data.pros.length==0);
	});
}

function pxquery(obj) {
	$('.px-ul li').removeClass('on');
	$(obj).addClass('on');

	var px = $(obj).attr('px');
	if(px != '2' && px != '3') {
		$('#jg-px').attr('src', '../img/wapApp/sort1.png');
		$('.price').attr('px', '3');
	} else if(px == '2') {
		$('#jg-px').attr('src', '../img/wapApp/sort3.png');
		$('.price').attr('px', '3');
	} else if(px == '3') {
		$('#jg-px').attr('src', '../img/wapApp/sort2.png');
		$('.price').attr('px', '2');
	}

	page.data.px = $(obj).attr('px');
	page.data.offset = 0;
	page.data.pros = [];
	loadPros();
}